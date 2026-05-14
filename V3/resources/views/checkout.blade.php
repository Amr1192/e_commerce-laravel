@extends('layout')

@section('title', 'Checkout')

@section('body', 'bg-gray-50')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <a href="{{ route('cart.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">← Back to cart</a>

        <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">Checkout</h1>
        <p class="mt-2 text-sm text-gray-600">Review your order and confirm. Payment and shipping can be wired in next.</p>

        @if ($errors->any())
            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-8 space-y-6">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 bg-gray-50 px-5 py-3">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-600">Order summary</h2>
                </div>
                <ul class="divide-y divide-gray-100">
                    @foreach ($lines as $line)
                        @php $p = $line->product; @endphp
                        <li class="flex items-center justify-between gap-4 px-5 py-4">
                            <div>
                                <p class="font-medium text-gray-900">{{ $p->name }}</p>
                                <p class="text-xs text-gray-500">× {{ $line->quantity }} @ {{ number_format((float) $p->price, 2) }} EGP</p>
                            </div>
                            <p class="shrink-0 text-sm font-semibold tabular-nums text-gray-900">
                                {{ number_format((float) $p->price * (int) $line->quantity, 2) }} EGP</p>
                        </li>
                    @endforeach
                </ul>
                <div class="flex items-center justify-between border-t border-gray-100 bg-gray-50 px-5 py-4">
                    <span class="text-sm font-medium text-gray-700">Total</span>
                    <span class="text-lg font-bold tabular-nums text-emerald-900">{{ number_format((float) $subtotal, 2) }} EGP</span>
                </div>
            </div>

            <div class="rounded-2xl border border-dashed border-amber-200 bg-amber-50/60 px-5 py-4 text-sm text-amber-950">
                <span class="font-semibold">Next steps:</span> this checkout records your order as <strong>pending</strong>. You can later add payment (card, wallet), shipping address, and email notifications.
            </div>

            <form action="{{ route('checkout.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="notes" class="mb-2 block text-sm font-semibold text-gray-800">Order notes <span
                            class="font-normal text-gray-500">(optional)</span></label>
                    <textarea name="notes" id="notes" rows="3" maxlength="500"
                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500/20 sm:text-sm"
                        placeholder="Delivery instructions or comments">{{ old('notes') }}</textarea>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('cart.index') }}"
                        class="inline-flex min-h-[48px] items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-50">
                        Return to cart
                    </a>
                    <button type="submit"
                        class="inline-flex min-h-[48px] items-center justify-center rounded-xl bg-emerald-600 px-8 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                        Place order
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
