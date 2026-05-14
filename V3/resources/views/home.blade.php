@extends('layout')

@section('title', 'Catalog')

@section('body', 'bg-gray-50')

@section('content')
    <div class="mx-auto max-w-7xl px-4 pb-12 pt-8 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Catalog</h1>
                <p class="mt-2 max-w-2xl text-gray-600">Browse products, filter by category, and add items to your cart.</p>
            </div>

            <form action="{{ route('products.index') }}" method="GET"
                class="w-full shrink-0 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:max-w-xs lg:w-72">
                <label for="category_id" class="block text-xs font-semibold uppercase tracking-wide text-gray-500">Category</label>
                <select name="category_id" id="category_id"
                    class="mt-2 block w-full rounded-xl border-gray-300 bg-gray-50 py-2.5 pl-3 pr-8 text-sm font-medium text-gray-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20"
                    onchange="this.form.submit()">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <x-cards :products="$products" />
    </div>
@endsection
