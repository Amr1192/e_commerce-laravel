@extends('layout')

@section('title', 'My orders')

@section('body', 'bg-gray-50')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-8 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">My orders</h1>
                <p class="mt-2 text-sm text-gray-600">Every order you have placed, with the latest status and totals.</p>
            </div>
            <a href="{{ route('products.index') }}"
                class="inline-flex shrink-0 items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-50">
                Continue shopping
            </a>
        </div>

        @if ($orders->isEmpty())
            <div class="mt-12 rounded-2xl border border-dashed border-gray-300 bg-white px-8 py-16 text-center shadow-sm">
                <p class="text-lg font-semibold text-gray-900">No orders yet</p>
                <p class="mt-2 text-sm text-gray-600">When you check out, your orders will show up here.</p>
                <a href="{{ route('cart.index') }}"
                    class="mt-6 inline-flex items-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">Go to cart</a>
            </div>
        @else
            {{-- Desktop --}}
            <div class="mt-8 hidden overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Order</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Date</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Items</th>
                            <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Total</th>
                            <th class="px-5 py-3.5"><span class="sr-only">View</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach ($orders as $order)
                            @php $s = $order->statusPresentation(); @endphp
                            <tr class="hover:bg-gray-50/80">
                                <td class="px-5 py-4">
                                    <span class="font-mono text-sm font-semibold text-gray-900">{{ $order->order_number }}</span>
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-600">
                                    {{ $order->created_at->timezone(config('app.timezone'))->format('M j, Y') }}
                                </td>
                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold uppercase tracking-wide ring-1 ring-inset {{ $s['badge'] }}">{{ $s['label'] }}</span>
                                    <p class="mt-1 max-w-xs text-xs text-gray-500">{{ $s['description'] }}</p>
                                </td>
                                <td class="px-5 py-4 text-right text-sm tabular-nums text-gray-700">{{ $order->items_count }}</td>
                                <td class="px-5 py-4 text-right text-sm font-semibold tabular-nums text-gray-900">
                                    {{ number_format((float) $order->grand_total, 2) }} {{ $order->currency }}</td>
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('orders.show', $order) }}"
                                        class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile --}}
            <div class="mt-8 space-y-4 md:hidden">
                @foreach ($orders as $order)
                    @php $s = $order->statusPresentation(); @endphp
                    <article class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-mono text-sm font-bold text-gray-900">{{ $order->order_number }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ $order->created_at->timezone(config('app.timezone'))->format('M j, Y g:i A') }}</p>
                            </div>
                            <span
                                class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide ring-1 ring-inset {{ $s['badge'] }}">{{ $s['label'] }}</span>
                        </div>
                        <p class="mt-3 text-xs text-gray-600">{{ $s['description'] }}</p>
                        <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-3">
                            <span class="text-sm text-gray-600">{{ $order->items_count }} items</span>
                            <span class="text-sm font-bold tabular-nums text-gray-900">{{ number_format((float) $order->grand_total, 2) }}
                                {{ $order->currency }}</span>
                        </div>
                        <a href="{{ route('orders.show', $order) }}"
                            class="mt-3 block w-full rounded-xl bg-emerald-600 py-2.5 text-center text-sm font-semibold text-white hover:bg-emerald-700">View
                            details</a>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                <x-pagination :paginator="$orders" />
            </div>
        @endif
    </div>
@endsection
