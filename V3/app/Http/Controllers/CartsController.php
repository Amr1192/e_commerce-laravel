<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartsController extends Controller
{
    public function index(Request $request, CartService $cartService)
    {
        $lines = $cartService->getLines($request);
        $subtotal = $lines->sum(fn ($line) => (float) $line->product->price * (int) $line->quantity);

        return view('cart', [
            'lines' => $lines,
            'subtotal' => $subtotal,
        ]);
    }

    public function store(Request $request, CartService $cartService)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:1000',
        ]);

        $cartService->add($request, (int) $data['product_id'], (int) ($data['quantity'] ?? 1));

        return redirect()
            ->route('cart.index')
            ->with('success', 'Added to your cart.');
    }

    public function update(Request $request, Product $product, CartService $cartService)
    {
        $this->authorizeCartLine($request, $cartService, $product);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $cartService->updateQuantity($request, $product, (int) $validated['quantity']);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart updated.');
    }

    public function destroy(Request $request, Product $product, CartService $cartService)
    {
        $this->authorizeCartLine($request, $cartService, $product);

        $cartService->remove($request, $product);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Item removed from your cart.');
    }

    private function authorizeCartLine(Request $request, CartService $cartService, Product $product): void
    {
        if (Auth::check()) {
            $owns = Cart::query()
                ->where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();
            if (! $owns) {
                abort(403);
            }

            return;
        }

        if (! $cartService->guestHasLine($request, $product)) {
            abort(403);
        }
    }
}
