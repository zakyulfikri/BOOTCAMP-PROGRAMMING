@extends('layouts.app2')

@section('title', 'Keranjang')

@section('content')
    <div class="mx-auto max-w-6xl">
        <div class="mb-8 flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-500">Shopping</p>
                <h1 class="mt-2 text-3xl font-black text-slate-900">Keranjang Saya</h1>
            </div>
            <a href="{{ route('home') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:border-red-200 hover:text-red-600">Lanjut Belanja</a>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($items->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center shadow-sm">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-3xl">🛒</div>
                <h2 class="text-xl font-bold text-slate-900">Keranjang masih kosong</h2>
                <p class="mt-2 text-slate-600">Tambahkan produk favorit Anda untuk mulai checkout.</p>
                <a href="{{ route('home') }}" class="mt-6 inline-flex rounded-full bg-red-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-red-200 hover:bg-red-700">Belanja Sekarang</a>
            </div>
        @else
            <div class="grid gap-6 lg:grid-cols-[1.7fr_0.9fr]">
                <div class="space-y-4">
                    @foreach ($items as $item)
                        <div class="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="h-28 w-28 rounded-2xl object-cover ring-1 ring-slate-200">

                            <div class="flex-1">
                                <h2 class="text-lg font-bold text-slate-900">{{ $item['name'] }}</h2>
                                <p class="mt-1 text-sm text-slate-500">Harga satuan</p>
                                <p class="mt-1 text-base font-bold text-slate-900">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>

                            <div class="flex items-center gap-3">
                                <form action="{{ route('cart.update', ['product' => $item['product_id']]) }}" method="POST">
                                    @csrf
                                    <div class="flex items-center rounded-xl border border-slate-200 bg-slate-50">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99" class="w-16 border-0 bg-transparent px-3 py-2 text-center text-sm font-semibold text-slate-900 focus:outline-none">
                                        <button type="submit" class="border-l border-slate-200 px-3 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 hover:bg-slate-100">Update</button>
                                    </div>
                                </form>

                                <form action="{{ route('cart.remove', ['product' => $item['product_id']]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-bold uppercase tracking-wide text-red-600 hover:bg-red-100">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <aside class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900">Ringkasan</h2>

                    <div class="mt-5 space-y-3 text-sm text-slate-600">
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

                    <a href="{{ route('checkout.page') }}" class="mt-6 block w-full rounded-xl bg-red-600 px-4 py-3 text-center text-sm font-bold text-white shadow-lg shadow-red-200 transition hover:bg-red-700">Lanjut ke Checkout</a>
                </aside>
            </div>
        @endif
    </div>
@endsection
