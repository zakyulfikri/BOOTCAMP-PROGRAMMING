@extends('layouts.app2')

@section('title', 'Checkout')

@section('content')
    <div class="mx-auto max-w-6xl">
        <div class="mb-8 flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-500">Payment</p>
                <h1 class="mt-2 text-3xl font-black text-slate-900">Checkout</h1>
            </div>
            <a href="{{ route('cart.index') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:border-red-200 hover:text-red-600">Kembali ke Keranjang</a>
        </div>

        @if (session('error'))
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-bold text-slate-900">Detail Pembeli</h2>

                <form action="{{ route('checkout') }}" method="POST" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <label for="customer_name" class="mb-1 block text-sm font-medium text-slate-700">Nama Lengkap</label>
                        <input id="customer_name" name="customer_name" type="text" value="{{ auth()->user()->name ?? '' }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 focus:border-red-300 focus:outline-none" required>
                    </div>

                    <div>
                        <label for="customer_phone" class="mb-1 block text-sm font-medium text-slate-700">No. HP</label>
                        <input id="customer_phone" name="customer_phone" type="text" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 focus:border-red-300 focus:outline-none" required>
                    </div>

                    <div>
                        <label for="customer_address" class="mb-1 block text-sm font-medium text-slate-700">Alamat Pengiriman</label>
                        <textarea id="customer_address" name="customer_address" rows="4" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 focus:border-red-300 focus:outline-none" required></textarea>
                    </div>

                    <div>
                        <label for="payment_method" class="mb-1 block text-sm font-medium text-slate-700">Metode Pembayaran</label>
                        <select id="payment_method" name="payment_method" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 focus:border-red-300 focus:outline-none" required>
                            <option value="transfer">Transfer Bank</option>
                            <option value="cod">Cash on Delivery (COD)</option>
                            <option value="ewallet">E-Wallet</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-red-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-red-200 transition hover:bg-red-700">Bayar Sekarang</button>
                </form>
            </div>

            <aside class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-bold text-slate-900">Ringkasan Pesanan</h2>

                <div class="mt-5 space-y-4">
                    @foreach ($items as $item)
                        <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-3">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="h-16 w-16 rounded-xl object-cover">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-slate-900">{{ $item['name'] }}</p>
                                <p class="text-xs text-slate-500">Qty: {{ $item['quantity'] }}</p>
                            </div>
                            <p class="text-sm font-bold text-slate-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 space-y-3 text-sm text-slate-600">
                    <div class="flex items-center justify-between">
                        <span>Subtotal</span>
                        <span class="font-semibold text-slate-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Pengiriman</span>
                        <span class="font-semibold text-slate-900">Rp 0</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-slate-200 pt-3 text-base font-bold text-slate-900">
                        <span>Total</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
