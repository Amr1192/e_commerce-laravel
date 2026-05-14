@extends('layout')

@section('title', 'Order ' . $order->order_number)

@section('body', 'bg-gray-50')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">← All my orders</a>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Order</p>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $order->order_number }}</h1>
                <p class="mt-1 text-sm text-gray-600">Placed {{ $order->created_at->timezone(config('app.timezone'))->format('M j, Y g:i A') }}</p>
            </div>
            @php $st = $order->statusPresentation(); @endphp
            <div class="flex max-w-md flex-col items-start gap-2 sm:items-end">
                <span
                    class="inline-flex w-fit shrink-0 rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide ring-1 ring-inset {{ $st['badge'] }}">{{ $st['label'] }}</span>
                <p class="text-right text-sm text-gray-600 sm:max-w-xs sm:text-right">{{ $st['description'] }}</p>
            </div>
        </div>

        <dl class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
            <div class="rounded-xl border border-gray-200 bg-white p-3 text-center shadow-sm">
                <dt class="text-xs text-gray-500">Subtotal</dt>
                <dd class="mt-1 text-sm font-semibold tabular-nums">{{ number_format((float) $order->subtotal, 2) }}</dd>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-3 text-center shadow-sm">
                <dt class="text-xs text-gray-500">Tax</dt>
                <dd class="mt-1 text-sm font-semibold tabular-nums">{{ number_format((float) $order->tax_total, 2) }}</dd>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-3 text-center shadow-sm">
                <dt class="text-xs text-gray-500">Shipping</dt>
                <dd class="mt-1 text-sm font-semibold tabular-nums">{{ number_format((float) $order->shipping_total, 2) }}</dd>
            </div>
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-center shadow-sm sm:col-span-1">
                <dt class="text-xs font-medium text-emerald-800">Total</dt>
                <dd class="mt-1 text-sm font-bold tabular-nums text-emerald-950">{{ number_format((float) $order->grand_total, 2) }}
                    {{ $order->currency }}</dd>
            </div>
        </dl>

        @if ($order->notes)
            <div class="mt-6 rounded-xl border border-gray-200 bg-white p-4 text-sm text-gray-700 shadow-sm">
                <span class="font-semibold text-gray-900">Your notes:</span> {{ $order->notes }}
            </div>
        @endif

        <div class="mt-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50 px-5 py-3">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-600">Items</h2>
            </div>
            <ul class="divide-y divide-gray-100">
                @foreach ($order->items as $item)
                    <li class="flex flex-col gap-1 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                            <p class="text-xs text-gray-500">SKU {{ $item->product_sku ?? '—' }} · Qty {{ $item->quantity }}</p>
                        </div>
                        <p class="text-sm font-semibold tabular-nums text-gray-900">{{ number_format((float) $item->line_total, 2) }}
                            {{ $order->currency }}</p>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-10 flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('orders.index') }}"
                class="inline-flex min-h-[48px] flex-1 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-50">
                All my orders
            </a>
            <a href="{{ route('products.index') }}"
                class="inline-flex min-h-[48px] flex-1 items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                Continue shopping
            </a>
            <a href="{{ route('cart.index') }}"
                class="inline-flex min-h-[48px] flex-1 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-50">
                View cart
            </a>
        </div>
    </div>
@endsection
