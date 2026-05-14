<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function ordersList(Request $request): View
    {
        $orders = Order::query()
            ->where('user_id', $request->user()->id)
            ->withCount('items')
            ->latest()
            ->paginate(12);

        return view('orders.index', compact('orders'));
    }

    public function index(Request $request, CartService $cartService): View|RedirectResponse
    {
        $lines = $cartService->getLines($request);
        if ($lines->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty. Add items before checking out.');
        }

        $subtotal = $lines->sum(fn ($line) => (float) $line->product->price * (int) $line->quantity);

        return view('checkout', [
            'lines' => $lines,
            'subtotal' => $subtotal,
        ]);
    }

    public function store(Request $request, CartService $cartService): RedirectResponse
    {
        $lines = $cartService->getLines($request);
        if ($lines->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $user = $request->user();
        $order = null;

        try {
            DB::transaction(function () use ($lines, $user, $request, &$order): void {
                foreach ($lines as $line) {
                    $product = Product::query()->lockForUpdate()->find($line->product->id);
                    if (! $product) {
                        throw ValidationException::withMessages([
                            'checkout' => 'A product in your cart is no longer available.',
                        ]);
                    }
                    if ($product->quantity < $line->quantity) {
                        throw ValidationException::withMessages([
                            'checkout' => "Not enough stock for «{$product->name}». Available: {$product->quantity}, in cart: {$line->quantity}.",
                        ]);
                    }
                }

                $subtotal = $lines->sum(fn ($line) => (float) $line->product->price * (int) $line->quantity);

                $order = Order::query()->create([
                    'user_id' => $user->id,
                    'status' => 'pending',
                    'currency' => 'EGP',
                    'subtotal' => $subtotal,
                    'tax_total' => 0,
                    'shipping_total' => 0,
                    'discount_total' => 0,
                    'grand_total' => $subtotal,
                    'notes' => $request->input('notes'),
                ]);

                foreach ($lines as $line) {
                    $product = Product::query()->lockForUpdate()->findOrFail($line->product->id);
                    $qty = (int) $line->quantity;

                    OrderItem::query()->create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'unit_price' => $product->price,
                    ]);

                    $product->decrement('quantity', $qty);
                }

                Cart::query()->where('user_id', $user->id)->delete();
            });
        } catch (ValidationException $e) {
            return redirect()
                ->route('checkout.index')
                ->withErrors($e->errors())
                ->withInput();
        }

        if (! $order) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Something went wrong completing your order. Please try again.');
        }

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Your order was placed successfully.');
    }

    public function show(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $order->load('items');

        return view('orders.show', compact('order'));
    }
}
