@extends('layout')
@section('title','create')
@section('content')

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="max-w-md mx-auto bg-white p-8 mt-10 rounded-lg shadow-md border border-gray-200">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Product</h2>

    <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Product Description</label>
            <input type="text" name="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Price ($)</label>
            <input type="number" step="0.01" name="price" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="0.00" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Quantity</label>
            <input type="number" name="quantity" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="0" required>
        </div>
        <div>
            <label class="block text-xl text-blue-700 my-2">category</label>
            <select name="category_id" id="">
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Product Image</label>
            <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
            Save Product
        </button>
    </form>
</div>
@endsection