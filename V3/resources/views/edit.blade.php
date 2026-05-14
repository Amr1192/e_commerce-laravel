@extends('layout')

@section('title', 'Edit: ' . $product->name)

@section('body', 'bg-gray-50')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-8 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Edit product</h1>
                <p class="mt-2 text-gray-600">Update listing details, pricing, and imagery.</p>
            </div>
            <a href="{{ route('products.show', $product->id) }}"
                class="inline-flex shrink-0 items-center gap-2 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                View product
            </a>
        </div>

        <div class="mt-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm ring-1 ring-gray-900/5">
            <form action="{{ route('products.put', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-gray-800">Product name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/20 sm:text-sm @error('name') border-red-400 @enderror"
                        placeholder="Product name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="mb-2 block text-sm font-semibold text-gray-800">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="4" required
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/20 sm:text-sm @error('description') border-red-400 @enderror"
                        placeholder="Description">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="mb-2 block text-sm font-semibold text-gray-800">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/20 sm:text-sm @error('category_id') border-red-400 @enderror">
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="mb-2 block text-sm font-semibold text-gray-800">Price (EGP) <span class="text-red-500">*</span></label>
                    <div class="relative mt-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-500">EGP</span>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required
                            class="block w-full rounded-xl border-gray-300 py-2.5 pl-12 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/20 sm:text-sm @error('price') border-red-400 @enderror"
                            placeholder="0.00">
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if ($product->image)
                    @php $thumb = '/' . ltrim($product->image, '/'); @endphp
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Current image</span>
                        <div class="mt-3 flex items-center gap-4">
                            <img src="{{ $thumb }}" alt="{{ $product->name }}" id="current-product-thumb"
                                class="h-24 w-24 rounded-xl object-cover ring-2 ring-white shadow">
                            <p class="text-sm text-gray-600">Upload a new file below to replace this image.</p>
                        </div>
                    </div>
                @endif

                <div>
                    <label for="image" class="mb-2 block text-sm font-semibold text-gray-800">Replace image</label>
                    <div id="image-upload-zone"
                        class="mt-1 flex justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50/50 px-6 py-8 transition hover:border-emerald-300 hover:bg-emerald-50/30">
                        <div class="text-center">
                            <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-3 flex flex-wrap justify-center gap-1 text-sm text-gray-600">
                                <label for="image" class="cursor-pointer font-semibold text-emerald-700 hover:text-emerald-900">
                                    <span>Choose a file</span>
                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <span>or drag into the file picker</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, WebP up to 10 MB</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('products.show', $product->id) }}"
                        class="inline-flex min-h-[48px] items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save changes
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Record</h2>
            <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-medium text-gray-500">Product ID</dt>
                    <dd class="mt-1 font-mono text-sm text-gray-900">#{{ $product->id }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500">Category</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $product->category->name ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500">SKU</dt>
                    <dd class="mt-1 font-mono text-sm text-gray-900">{{ $product->sku }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $product->status }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <script>
        document.getElementById('image')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(ev) {
                let preview = document.getElementById('image-preview-new');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'image-preview-new';
                    preview.className = 'mt-3 h-24 w-24 rounded-xl object-cover ring-2 ring-emerald-200';
                    const zone = document.getElementById('image-upload-zone');
                    zone?.parentElement?.appendChild(preview);
                }
                preview.src = ev.target.result;
                preview.alt = 'Preview';
            };
            reader.readAsDataURL(file);
        });

        document.querySelector('form')?.addEventListener('submit', function(e) {
            const price = document.getElementById('price')?.value;
            if (price !== undefined && price !== '' && parseFloat(price) < 0) {
                e.preventDefault();
                alert('Price cannot be negative');
            }
        });
    </script>
@endsection
