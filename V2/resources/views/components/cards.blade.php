@props(['products'])
@if(session('error'))
    <div style="background: #f8d7da; color: #842029; padding: 10px; margin: 10px 0; border-radius: 5px;">
        {{ session('error') }}
    </div>
@endif

<header>
    <h2 class="text-2xl text-center mt-4">Welcome to my website</h2>
</header>

<div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 justify-items-center max-w-7xl mx-auto">
    @foreach ($products as $product)
        <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow p-5 flex flex-col h-full">
            <!-- Fixed height image container -->
            <div class="w-full h-48 overflow-hidden rounded-t-lg bg-gray-100">
                <img class="w-full h-full object-cover" 
                     src="{{ $product->image }}" 
                     alt="{{ $product->name }}" />
            </div>

            <!-- Content section with flex-grow -->
            <div class="mt-4 flex-1 flex flex-col">
                <h5 class="text-xl font-bold text-gray-900">{{ $product->name }}</h5>
                <p class="mt-2 text-gray-700 flex-1">
                    {{ $product->description }}
                </p>
                <div class="flex justify-between">
                    <h2 class="mt-2 text-green-700 text-lg font-semibold">
                        Price: {{ $product->price }} EGP
                    </h2>
                    <h2 class="mt-2 text-blue-600 text-lg font-semibold">
                        Quantity: {{ $product->quantity }}
                    </h2>
                </div>
            </div>

            <!-- Button section -->
            <div class="flex flex-col sm:flex-row gap-2 mt-4">
                <a href="{{ route('products.show', $product->id) }}"
                   class="flex-1 text-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    More details
                </a>
                <a href="/cart"
                   class="flex-1 text-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                    Add to cart
                </a>
                @auth
                @can('delete')
                     <form action="/products/{{ $product->id }}" method="POST" class="flex-1">
                    @method('DELETE')
                    @csrf
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors"
                            onclick="return confirm('Are you sure you want to delete this product?')">
                        Delete
                    </button>
                </form>
                @endcan
                @endauth
            </div>
        </div>
    @endforeach
</div>

<!-- Custom Pagination -->
<x-pagination :paginator="$products" />