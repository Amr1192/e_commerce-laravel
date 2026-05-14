@extends('layout')

@section('title', 'Cart')

@section('body', 'bg-gray-50')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col gap-2 border-b border-gray-200 pb-8 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Your cart</h1>
                @guest
                    <p class="mt-2 max-w-xl text-sm text-gray-600">
                        Guest checkout: items are stored in this browser session. <a href="{{ route('showLogin') }}"
                            class="font-semibold text-emerald-700 underline decoration-emerald-200 underline-offset-2 hover:text-emerald-900">Sign
                            in</a> to sync your cart to your account.
                    </p>
                @else
                    <p class="mt-2 text-sm text-gray-600">
                        Signed in as <span class="font-semibold text-gray-900">{{ auth()->user()->name }}</span> — your
                        cart is saved to your account.
                    </p>
                @endguest
            </div>
            <a href="{{ route('products.index') }}"
                class="mt-4 inline-flex shrink-0 items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50 sm:mt-0">
                Continue shopping
            </a>
        </div>

        @if ($lines->isEmpty())
            <div class="mt-10 rounded-2xl border border-dashed border-gray-300 bg-white px-8 py-16 text-center shadow-sm">
                <p class="text-lg font-semibold text-gray-900">Your cart is empty</p>
                <p class="mt-2 text-sm text-gray-600">Discover products on the catalog and add them here.</p>
                <a href="{{ route('products.index') }}"
                    class="mt-6 inline-flex items-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                    Browse catalog
                </a>
                @guest
                    <p class="mt-6 text-sm text-gray-500">
                        <a href="{{ route('showLogin') }}" class="font-semibold text-emerald-700 hover:underline">Log in</a>
                        for a cart that follows you across sessions.
                    </p>
                @endguest
            </div>
        @else
            {{-- Desktop table --}}
            <div class="mt-8 hidden overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Product</th>
                            <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Price</th>
                            <th class="px-5 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Quantity</th>
                            <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Line total</th>
                            <th class="px-5 py-3.5"><span class="sr-only">Remove</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach ($lines as $line)
                            @php
                                $p = $line->product;
                                $img = $p->image ? '/' . ltrim($p->image, '/') : '';
                            @endphp
                            <tr class="hover:bg-gray-50/80">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-4">
                                        @if ($img)
                                            <img src="{{ $img }}" alt="" class="h-14 w-14 rounded-lg object-cover ring-1 ring-gray-100">
                                        @endif
                                        <div>
                                            <a href="{{ route('products.show', $p->id) }}"
                                                class="font-semibold text-gray-900 hover:text-emerald-700">{{ $p->name }}</a>
                                            <p class="text-xs text-gray-500">SKU {{ $p->sku }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-right text-sm tabular-nums text-gray-700">
                                    {{ number_format((float) $p->price, 2) }} EGP</td>
                                <td class="px-5 py-4">
                                    <form action="{{ route('cart.items.update', $p) }}" method="POST"
                                        class="mx-auto flex max-w-[140px] items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $line->quantity }}" min="0"
                                            max="{{ $p->quantity }}"
                                            class="w-full rounded-lg border-gray-300 text-center text-sm font-semibold tabular-nums shadow-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                        <button type="submit"
                                            class="shrink-0 rounded-lg bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-800 ring-1 ring-emerald-200 hover:bg-emerald-100">Update</button>
                                    </form>
                                </td>
                                <td class="px-5 py-4 text-right text-sm font-semibold tabular-nums text-gray-900">
                                    {{ number_format((float) $p->price * (int) $line->quantity, 2) }} EGP</td>
                                <td class="px-5 py-4 text-right">
                                    <form action="{{ route('cart.items.destroy', $p) }}" method="POST"
                                        onsubmit="return confirm('Remove this item from your cart?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-sm font-semibold text-red-600 hover:text-red-800">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex items-center justify-between border-t border-gray-100 bg-gray-50 px-5 py-4">
                    <span class="text-sm font-medium text-gray-600">Subtotal</span>
                    <span class="text-lg font-bold tabular-nums text-gray-900">{{ number_format((float) $subtotal, 2) }}
                        EGP</span>
                </div>
            </div>

            {{-- Mobile cards --}}
            <div class="mt-8 space-y-4 md:hidden">
                @foreach ($lines as $line)
                    @php
                        $p = $line->product;
                        $img = $p->image ? '/' . ltrim($p->image, '/') : '';
                    @endphp
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                        <div class="flex gap-4">
                            @if ($img)
                                <img src="{{ $img }}" alt="" class="h-20 w-20 shrink-0 rounded-xl object-cover ring-1 ring-gray-100">
                            @endif
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('products.show', $p->id) }}"
                                    class="font-semibold text-gray-900 hover:text-emerald-700">{{ $p->name }}</a>
                                <p class="mt-1 text-xs text-gray-500">SKU {{ $p->sku }}</p>
                                <p class="mt-2 text-sm text-gray-600">{{ number_format((float) $p->price, 2) }} EGP each</p>
                            </div>
                        </div>
                        <form action="{{ route('cart.items.update', $p) }}" method="POST" class="mt-4 flex flex-wrap items-end gap-3">
                            @csrf
                            @method('PATCH')
                            <div class="flex-1">
                                <label class="mb-1 block text-xs font-semibold uppercase text-gray-500">Quantity</label>
                                <input type="number" name="quantity" value="{{ $line->quantity }}" min="0" max="{{ $p->quantity }}"
                                    class="w-full rounded-xl border-gray-300 text-center text-lg font-bold tabular-nums shadow-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                            </div>
                            <button type="submit"
                                class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">Update</button>
                        </form>
                        <div class="mt-3 flex items-center justify-between border-t border-gray-100 pt-3">
                            <span class="text-sm font-medium text-gray-600">Line total</span>
                            <span class="text-base font-bold tabular-nums text-gray-900">{{ number_format((float) $p->price * (int) $line->quantity, 2) }}
                                EGP</span>
                        </div>
                        <form action="{{ route('cart.items.destroy', $p) }}" method="POST" class="mt-3"
                            onsubmit="return confirm('Remove this item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full rounded-xl border border-red-200 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Remove
                                from cart</button>
                        </form>
                    </div>
                @endforeach
                <div class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-4 text-right">
                    <span class="text-sm font-medium text-gray-600">Subtotal </span>
                    <span class="text-lg font-bold tabular-nums text-gray-900">{{ number_format((float) $subtotal, 2) }}
                        EGP</span>
                </div>
            </div>

            <div
                class="mt-8 flex flex-col gap-3 rounded-2xl border border-emerald-200 bg-gradient-to-r from-emerald-50 to-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-emerald-900">Ready to buy?</p>
                    <p class="mt-1 text-sm text-gray-600">
                        @guest
                            Sign in to place your order — your session cart will merge into your account.
                        @else
                            Confirm your items and place a pending order (payment &amp; shipping can be added later).
                        @endguest
                    </p>
                    <p class="mt-2 text-lg font-bold tabular-nums text-gray-900">{{ number_format((float) $subtotal, 2) }} EGP</p>
                </div>
                <a href="{{ route('checkout.index') }}"
                    class="inline-flex min-h-[48px] shrink-0 items-center justify-center rounded-xl bg-emerald-600 px-6 py-3 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                    Proceed to checkout
                </a>
            </div>
        @endif
    </div>
@endsection
