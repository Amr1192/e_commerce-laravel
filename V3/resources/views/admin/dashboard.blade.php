@extends('layout')

@section('title', 'Dashboard')

@section('body', 'bg-gray-50')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-8 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Admin dashboard</h1>
                <p class="mt-2 text-gray-600">Overview and quick links for your store.</p>
            </div>
            <a href="{{ route('products.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50">
                View storefront
            </a>
        </div>

        <dl class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white p-6 shadow-sm">
                <dt class="text-xs font-semibold uppercase tracking-wider text-emerald-800">Products</dt>
                <dd class="mt-2 text-3xl font-bold tabular-nums text-emerald-950">{{ $productCount }}</dd>
            </div>
            <div class="rounded-2xl border border-sky-100 bg-gradient-to-br from-sky-50 to-white p-6 shadow-sm">
                <dt class="text-xs font-semibold uppercase tracking-wider text-sky-800">Customers</dt>
                <dd class="mt-2 text-3xl font-bold tabular-nums text-sky-950">{{ $userCount }}</dd>
            </div>
            <div class="rounded-2xl border border-violet-100 bg-gradient-to-br from-violet-50 to-white p-6 shadow-sm">
                <dt class="text-xs font-semibold uppercase tracking-wider text-violet-800">Orders</dt>
                <dd class="mt-2 text-3xl font-bold tabular-nums text-violet-950">{{ $orderCount }}</dd>
            </div>
        </dl>

        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('products.create') }}"
                class="group flex flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-emerald-300 hover:shadow-md">
                <span class="text-lg font-semibold text-gray-900 group-hover:text-emerald-700">Add product</span>
                <span class="mt-2 text-sm text-gray-600">Create a new catalog listing with images and pricing.</span>
            </a>
            <a href="{{ route('products.index') }}"
                class="group flex flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-sky-300 hover:shadow-md">
                <span class="text-lg font-semibold text-gray-900 group-hover:text-sky-700">Browse catalog</span>
                <span class="mt-2 text-sm text-gray-600">See the store as customers see it.</span>
            </a>
            <a href="{{ route('cart.index') }}"
                class="group flex flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-gray-300 hover:shadow-md sm:col-span-2 lg:col-span-1">
                <span class="text-lg font-semibold text-gray-900">Your cart</span>
                <span class="mt-2 text-sm text-gray-600">Test the shopping flow with your admin account.</span>
            </a>
        </div>
    </div>
@endsection
