@extends('layout')

@section('title', $product->name)

@section('body', 'bg-gray-50')

@section('content')
    @php
        $img = $product->image ? '/' . ltrim($product->image, '/') : null;
        $inStock = $product->quantity > 0;
    @endphp

    <div class="min-h-[calc(100vh-5rem)] w-full px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-5xl">
            {{-- Product shell --}}
            <div
                class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm ring-1 ring-gray-900/5">
                <div class="grid gap-0 lg:grid-cols-12 lg:gap-0">
                    {{-- Gallery --}}
                    <div class="lg:col-span-5 border-b border-gray-100 bg-gradient-to-b from-gray-50 to-white p-6 sm:p-8 lg:border-b-0 lg:border-r">
                        <div
                            class="mx-auto flex aspect-square max-h-[420px] w-full max-w-md items-center justify-center rounded-xl bg-white p-4 ring-1 ring-gray-100 lg:mx-0 lg:max-h-none">
                            @if ($img)
                                <img src="{{ $img }}" alt="{{ $product->name }}"
                                    class="max-h-full max-w-full object-contain">
                            @else
                                <span class="text-sm font-medium text-gray-400">No image</span>
                            @endif
                        </div>
                    </div>

                    {{-- Details & actions --}}
                    <div class="flex flex-col lg:col-span-7">
                        <div class="flex flex-1 flex-col p-6 sm:p-8">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                                    {{ $product->name }}
                                </h1>
                                @auth
                                    @can('edit')
                                        <span
                                            class="inline-flex shrink-0 items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-amber-900 ring-1 ring-inset ring-amber-200">
                                            Admin
                                        </span>
                                    @endcan
                                @endauth
                            </div>

                            @if ($product->category)
                                <p class="mt-2 text-sm text-gray-500">
                                    <span class="font-medium text-gray-600">Category:</span>
                                    {{ $product->category->name }}
                                </p>
                            @endif

                            <div class="mt-5 text-sm leading-relaxed text-gray-600 sm:text-base">
                                <p class="whitespace-pre-line">{{ $product->description }}</p>
                            </div>

                            {{-- Price + stock (always visible) --}}
                            <dl class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="rounded-xl border border-emerald-200 bg-emerald-50/80 p-4 sm:p-5">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-emerald-800/90">
                                        Price
                                    </dt>
                                    <dd class="mt-1 text-2xl font-bold tabular-nums text-emerald-900 sm:text-3xl">
                                        {{ number_format((float) $product->price, 2) }}
                                        <span class="text-base font-semibold text-emerald-800">EGP</span>
                                    </dd>
                                </div>
                                <div
                                    class="rounded-xl border p-4 sm:p-5 {{ $inStock ? 'border-sky-200 bg-sky-50/80' : 'border-red-200 bg-red-50/80' }}">
                                    <dt
                                        class="text-xs font-semibold uppercase tracking-wider {{ $inStock ? 'text-sky-900/90' : 'text-red-900/90' }}">
                                        Available in store
                                    </dt>
                                    <dd
                                        class="mt-1 text-2xl font-bold tabular-nums sm:text-3xl {{ $inStock ? 'text-sky-950' : 'text-red-900' }}">
                                        {{ $inStock ? $product->quantity : '0' }}
                                        <span class="text-base font-semibold {{ $inStock ? 'text-sky-800' : 'text-red-800' }}">
                                            {{ Str::plural('unit', $product->quantity) }}
                                        </span>
                                    </dd>
                                    @unless ($inStock)
                                        <p class="mt-2 text-sm font-medium text-red-800">Currently out of stock</p>
                                    @endunless
                                </div>
                            </dl>

                            @guest
                                <p class="mt-6 rounded-lg border border-dashed border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-600">
                                    <span class="font-medium text-gray-800">Browsing as a guest?</span>
                                    Your cart is kept for this browser session. <a href="{{ route('showLogin') }}"
                                        class="font-semibold text-emerald-700 underline decoration-emerald-300 underline-offset-2 hover:text-emerald-900">Sign
                                        in</a> to keep your cart on your account.
                                </p>
                            @endguest

                            @auth
                            
                            @endauth

                            @if ($inStock)
                                {{-- Quantity to add (highlighted) --}}
                                <div class="mt-8">
                                    <form action="{{ route('cart.items.store') }}" method="POST"
                                        class="rounded-2xl border-2 border-blue-200 bg-gradient-to-br from-blue-50/90 to-white p-5 shadow-inner sm:p-6">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        <fieldset class="m-0 min-w-0 border-0 p-0">
                                            <legend
                                                class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-gray-800">
                                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white"
                                                    aria-hidden="true">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                    </svg>
                                                </span>
                                                How many do you want?
                                            </legend>
                                            <p class="mt-1 text-sm text-gray-600">Choose how many units to add to your cart
                                                (max {{ $product->quantity }}).</p>

                                            <div class="mt-5 flex flex-col gap-4 sm:flex-row sm:items-end">
                                                <div class="flex-1">
                                                    <label for="cart_qty"
                                                        class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-500">Quantity</label>
                                                    <div class="relative">
                                                        <input id="cart_qty" name="quantity" type="number" value="1"
                                                            min="1" max="{{ $product->quantity }}" inputmode="numeric"
                                                            class="block w-full rounded-xl border-2 border-blue-300 bg-white py-3.5 pl-4 pr-4 text-center text-2xl font-bold tabular-nums text-gray-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/20 sm:max-w-[200px] sm:text-3xl"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="sm:pb-0.5">
                                                    <button type="submit"
                                                        class="inline-flex w-full min-h-[52px] items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3.5 text-base font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/40 sm:w-auto sm:min-w-[200px]">
                                                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                        Add to cart
                                                    </button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            @else
                                <div
                                    class="mt-8 rounded-2xl border border-gray-200 bg-gray-50 px-5 py-6 text-center text-gray-600">
                                    <p class="font-medium text-gray-800">You can’t add this item right now.</p>
                                    <p class="mt-1 text-sm">Check back later or browse similar products.</p>
                                </div>
                            @endif

                            @php
                                $canEditProduct = auth()->check() && auth()->user()->can('edit');
                                $canDeleteProduct = auth()->check() && auth()->user()->can('delete');
                                $adminActionCount = ($canEditProduct ? 1 : 0) + ($canDeleteProduct ? 1 : 0);
                            @endphp

                            {{-- Secondary actions: back + optional edit / delete --}}
                            <div
                                @class([
                                    'mt-8 grid grid-cols-1 gap-3 border-t border-gray-100 pt-8',
                                    'sm:grid-cols-3' => $adminActionCount === 2,
                                    'sm:grid-cols-2' => $adminActionCount === 1,
                                    'sm:grid-cols-1' => $adminActionCount === 0,
                                ])>
                                <a href="{{ route('products.index') }}"
                                    class="inline-flex min-h-[48px] w-full cursor-pointer items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-center text-sm font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50">
                                    ← Back to products
                                </a>

                                @auth
                                    @can('edit')
                                        <form action="{{ route('products.edit', $product->id) }}" method="GET" class="flex w-full min-w-0">
                                            <button type="submit"
                                                class="inline-flex min-h-[48px] w-full flex-1 cursor-pointer items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                                                Edit product
                                            </button>
                                        </form>
                                    @endcan
                                    @can('delete')
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex w-full min-w-0"
                                            onsubmit="return confirm('Delete this product permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex min-h-[48px] w-full flex-1 cursor-pointer items-center justify-center rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">
                                                Delete product
                                            </button>
                                        </form>
                                    @endcan
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
