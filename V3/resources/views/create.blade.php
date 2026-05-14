@extends('layout')

@section('title', 'Add product')

@section('body', 'bg-gray-50')

@section('content')
    <div class="mx-auto max-w-2xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('products.index') }}"
                class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">← Back to catalog</a>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">Add product</h1>
            <p class="mt-2 text-gray-600">Fill in the details below. All fields marked * are required.</p>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm ring-1 ring-gray-900/5">
            @if ($errors->any())
                <div class="border-b border-red-100 bg-red-50 px-6 py-4">
                    <p class="text-sm font-semibold text-red-800">Please fix the following:</p>
                    <ul class="mt-2 list-inside list-disc text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6 sm:p-8">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-gray-800">Product name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/20 sm:text-sm">
                </div>

                <div>
                    <label for="description" class="mb-2 block text-sm font-semibold text-gray-800">Description <span
                            class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="4" required
                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/20 sm:text-sm"
                        placeholder="Describe the product for customers">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="category_id" class="mb-2 block text-sm font-semibold text-gray-800">Category <span
                            class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required
                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/20 sm:text-sm">
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="price" class="mb-2 block text-sm font-semibold text-gray-800">Price (EGP) <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-500">EGP</span>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0"
                                required
                                class="block w-full rounded-xl border-gray-300 py-2.5 pl-12 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/20 sm:text-sm"
                                placeholder="0.00">
                        </div>
                    </div>
                    <div>
                        <label for="quantity" class="mb-2 block text-sm font-semibold text-gray-800">Stock quantity <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 0) }}" min="0"
                            required
                            class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/20 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="image" class="mb-2 block text-sm font-semibold text-gray-800">Product image</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-800 hover:file:bg-emerald-100">
                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, WebP, or GIF up to 10 MB.</p>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('products.index') }}"
                        class="inline-flex min-h-[48px] items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex min-h-[48px] items-center justify-center rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                        Save product
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
