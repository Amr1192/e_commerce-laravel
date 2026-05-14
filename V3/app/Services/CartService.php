<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartService
{
    private const SESSION_KEY = 'guest_cart';

    /**
     * @param  array<mixed, mixed>  $cart
     * @return array<int, int>
     */
    private function normalizeGuestCartArray(array $cart): array
    {
        $out = [];
        foreach ($cart as $productId => $qty) {
            if (! is_numeric($productId) || ! is_numeric($qty)) {
                continue;
            }
            $pid = (int) $productId;
            $out[$pid] = (int) $qty;
        }

        return $out;
    }

    /**
     * @return Collection<int, object{product: Product, quantity: int}>
     */
    public function getLines(Request $request): Collection
    {
        if (Auth::check()) {
            return Cart::query()
                ->where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->filter(fn (Cart $row) => $row->product !== null)
                ->map(fn (Cart $row) => (object) [
                    'product' => $row->product,
                    'quantity' => (int) $row->quantity,
                ])
                ->values();
        }

        $guest = $request->session()->get(self::SESSION_KEY, []);
        if (! is_array($guest)) {
            $guest = [];
        }
        $guest = $this->normalizeGuestCartArray($guest);

        return collect($guest)
            ->map(function (mixed $qty, mixed $productId) {
                if (! is_numeric($productId) || ! is_numeric($qty)) {
                    return null;
                }
                $product = Product::query()->find((int) $productId);
                if (! $product) {
                    return null;
                }

                return (object) [
                    'product' => $product,
                    'quantity' => min((int) $qty, max(0, (int) $product->quantity)),
                ];
            })
            ->filter()
            ->values();
    }

    public function add(Request $request, int $productId, int $quantity): void
    {
        $quantity = max(1, $quantity);
        $product = Product::query()->findOrFail($productId);
        $quantity = min($quantity, max(0, (int) $product->quantity));
        if ($quantity < 1) {
            return;
        }

        if (Auth::check()) {
            $row = Cart::query()->firstOrNew([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
            $current = (int) $row->quantity;
            $row->quantity = min($current + $quantity, max(0, (int) $product->quantity));
            $row->save();

            return;
        }

        $cart = $request->session()->get(self::SESSION_KEY, []);
        if (! is_array($cart)) {
            $cart = [];
        }
        $cart = $this->normalizeGuestCartArray($cart);
        $current = (int) ($cart[$productId] ?? 0);
        $cart[$productId] = min($current + $quantity, max(0, (int) $product->quantity));
        if ($cart[$productId] < 1) {
            unset($cart[$productId]);
        }
        $request->session()->put(self::SESSION_KEY, $cart);
    }

    public function updateQuantity(Request $request, Product $product, int $quantity): void
    {
        $quantity = max(0, $quantity);
        $quantity = min($quantity, max(0, (int) $product->quantity));

        if (Auth::check()) {
            $row = Cart::query()
                ->where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();
            if (! $row) {
                return;
            }
            if ($quantity < 1) {
                $row->delete();

                return;
            }
            $row->quantity = $quantity;
            $row->save();

            return;
        }

        $cart = $request->session()->get(self::SESSION_KEY, []);
        if (! is_array($cart)) {
            $cart = [];
        }
        $cart = $this->normalizeGuestCartArray($cart);
        if ($quantity < 1) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = $quantity;
        }
        $request->session()->put(self::SESSION_KEY, $cart);
    }

    public function remove(Request $request, Product $product): void
    {
        $this->updateQuantity($request, $product, 0);
    }

    /**
     * @param  array<int|string, mixed>  $guestCart  product_id => quantity
     */
    public function mergeGuestSessionIntoUser(User $user, array $guestCart): void
    {
        $guestCart = $this->normalizeGuestCartArray($guestCart);
        foreach ($guestCart as $productId => $qty) {
            if (! is_numeric($productId) || ! is_numeric($qty)) {
                continue;
            }
            $product = Product::query()->find((int) $productId);
            if (! $product) {
                continue;
            }
            $addQty = min((int) $qty, max(0, (int) $product->quantity));
            if ($addQty < 1) {
                continue;
            }
            $row = Cart::query()->firstOrNew([
                'user_id' => $user->id,
                'product_id' => (int) $productId,
            ]);
            $current = (int) $row->quantity;
            $row->quantity = min($current + $addQty, max(0, (int) $product->quantity));
            $row->save();
        }
    }

    public function forgetGuestSession(Request $request): void
    {
        $request->session()->forget(self::SESSION_KEY);
    }

    public function guestHasLine(Request $request, Product $product): bool
    {
        $raw = $request->session()->get(self::SESSION_KEY, []);
        if (! is_array($raw)) {
            return false;
        }
        $cart = $this->normalizeGuestCartArray($raw);

        return array_key_exists($product->id, $cart);
    }
}
