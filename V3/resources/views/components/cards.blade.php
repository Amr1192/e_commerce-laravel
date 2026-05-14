@props(['products'])

@if (session('error'))
    <div class="mx-auto mb-6 max-w-7xl rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="mx-auto mb-6 max-w-7xl rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
        {{ session('success') }}
    </div>
@endif

<div class="mx-auto mt-8 grid max-w-7xl grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
    @foreach ($products as $product)
        @php
            $img = $product->image ? '/' . ltrim($product->image, '/') : null;
        @endphp
        <article
            class="flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm ring-1 ring-gray-900/5 transition hover:border-emerald-200/80 hover:shadow-md">
            <div class="relative aspect-[4/3] w-full overflow-hidden bg-gradient-to-br from-gray-100 to-gray-50">
                @if ($img)
                    <img src="{{ $img }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                @else
                    <div class="flex h-full items-center justify-center text-sm font-medium text-gray-400">No image</div>
                @endif
                @if ($product->quantity < 1)
                    <span
                        class="absolute right-3 top-3 rounded-full bg-red-600 px-2.5 py-0.5 text-xs font-bold uppercase tracking-wide text-white shadow">Out
                        of stock</span>
                @endif
            </div>

            <div class="flex flex-1 flex-col p-5">
                <h2 class="line-clamp-2 text-lg font-bold leading-snug text-gray-900">{{ $product->name }}</h2>
                <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-gray-600">{{ $product->description }}</p>

                <dl class="mt-4 grid grid-cols-2 gap-3">
                    <div class="rounded-lg bg-emerald-50 px-3 py-2 ring-1 ring-emerald-100">
                        <dt class="text-[10px] font-semibold uppercase tracking-wider text-emerald-800">Price</dt>
                        <dd class="text-sm font-bold tabular-nums text-emerald-950">{{ number_format((float) $product->price, 2) }}
                            <span class="text-xs font-semibold text-emerald-800">EGP</span></dd>
                    </div>
                    <div class="rounded-lg bg-sky-50 px-3 py-2 ring-1 ring-sky-100">
                        <dt class="text-[10px] font-semibold uppercase tracking-wider text-sky-800">In stock</dt>
                        <dd class="text-sm font-bold tabular-nums text-sky-950">{{ $product->quantity }}</dd>
                    </div>
                </dl>

                @php
                    $showDelete = auth()->check() && auth()->user()->can('delete');
                @endphp

                <div
                    @class([
                        'mt-5 grid grid-cols-1 gap-2',
                        'sm:grid-cols-3' => $showDelete,
                        'sm:grid-cols-2' => ! $showDelete,
                    ])>
                    <a href="{{ route('products.show', $product->id) }}"
                        class="flex min-h-[44px] w-full items-center justify-center rounded-xl border border-gray-300 bg-white px-2 text-center text-sm font-semibold leading-tight text-gray-800 shadow-sm transition hover:bg-gray-50">
                        Details
                    </a>
                    @if ($product->quantity > 0)
                        <form action="{{ route('cart.items.store') }}" method="POST" class="flex min-h-[44px] w-full min-w-0">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                class="flex w-full min-h-[44px] flex-1 items-center justify-center rounded-xl bg-emerald-600 px-2 text-center text-xs font-semibold leading-tight text-white shadow-sm transition hover:bg-emerald-700 sm:text-sm whitespace-nowrap">
                                Add to cart
                            </button>
                        </form>
                    @else
                        <span
                            class="flex min-h-[44px] w-full items-center justify-center rounded-xl bg-gray-100 px-2 text-center text-sm font-semibold leading-tight text-gray-500">
                            Unavailable
                        </span>
                    @endif
                    @auth
                        @can('delete')
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex min-h-[44px] w-full min-w-0">
                                @method('DELETE')
                                @csrf
                                <button type="submit"
                                    class="flex w-full min-h-[44px] flex-1 items-center justify-center rounded-xl bg-red-600 px-2 text-center text-xs font-semibold leading-tight text-white shadow-sm transition hover:bg-red-700 sm:text-sm whitespace-nowrap"
                                    onclick="return confirm('Delete this product permanently?')">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    @endauth
                </div>
            </div>
        </article>
    @endforeach
</div>

<x-pagination :paginator="$products" />
