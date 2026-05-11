@extends('layout')
@section('title','home')
@section('content')
<div class="flex justify-end items-center px-40 pt-5">
    <form action="{{ route('products.index') }}" method="GET">
    <select name="category_id" id="category_id" class="bg-cyan-100 rounded-md " onchange="this.form.submit()">
        <option value="">All Categories</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"{{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
    </form>
</div>
<x-cards :products="$products"></x-cards>
@endsection