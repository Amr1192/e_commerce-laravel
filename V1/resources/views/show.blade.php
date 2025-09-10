@extends('layout')
@section('title', 'show')
@section('content')
<div class="w-full overflow-x-hidden flex items-center min-h-screen justify-center p-4">
    <div class="max-w-md bg-white border border-gray-200 rounded-lg shadow p-6">
        <!-- Optimized image container for product photos -->
        <div class="w-full max-w-sm mx-auto h-96 overflow-hidden rounded-t-lg bg-white border border-gray-100 flex items-center justify-center p-4">
            <img class="max-w-full max-h-full object-contain" 
                 src="{{ '/' . $product->image }}" 
                 alt="{{ $product->name }}" />
        </div>

        <div class="mt-4">
            <h5 class="text-xl font-bold text-gray-900">{{ $product->name }}</h5>
            <p class="mt-2 text-gray-700">
                {{ $product->description }}
            </p>
            <h2 class="mt-2 text-green-700 text-lg font-semibold">
                Price: {{ $product->price }} EGP
            </h2>

            <div class="flex flex-col sm:flex-row gap-3 mt-6">
                <a href="/cart"
                   class="text-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Add to cart
                </a>

                @auth
                @can('edit')
                       <form action="/products/{{ $product->id }}/edit" method="GET" class="flex-1">
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors cursor-pointer">
                        Edit Product
                    </button>
                </form>
                @endcan
                @endauth
                
                <a href="{{ route('products.index') }}" 
                   class="flex-1 text-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                Back to Products
                </a>
            </div>
        </div>
    </div>
</div>
@endsection