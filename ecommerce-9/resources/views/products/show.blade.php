@extends('layouts.app2')

@section('title', $product->name)

@section('content')
    <div class="mx-auto max-w-6xl">
        <div class="mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-700">
                ← Kembali ke Beranda
            </a>
        </div>

        <div class="grid gap-8 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm md:grid-cols-2 md:p-8">
            <div class="overflow-hidden rounded-[24px] border border-slate-200 bg-slate-50">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
            </div>

            <div class="flex flex-col justify-center">
                <span class="inline-flex w-fit rounded-full bg-red-100 px-3 py-1 text-xs font-bold uppercase tracking-[0.2em] text-red-600">
                    {{ $product->category->name ?? 'Kategori' }}
                </span>

                <h1 class="mt-4 text-3xl font-black text-slate-900 md:text-4xl">{{ $product->name }}</h1>

                <div class="mt-4 flex items-center gap-3">
                    <span class="text-3xl font-black text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-emerald-700">
                        {{ $product->stock }} stok tersedia
                    </span>
                </div>

                <p class="mt-5 text-base leading-7 text-slate-600">{{ $product->description }}</p>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full rounded-xl bg-red-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-red-200 transition hover:bg-red-700">Tambah ke Keranjang</button>
                    </form>
                    <a href="{{ route('shop.products') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">Lihat Produk Lainnya</a>
                </div>

                <div class="mt-8 grid gap-3 border-t border-slate-200 pt-5 text-sm text-slate-600 sm:grid-cols-3">
                    <div>
                        <p class="font-semibold text-slate-800">Kategori</p>
                        <p class="mt-1">{{ $product->category->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Stok</p>
                        <p class="mt-1">{{ $product->stock }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Klik</p>
                        <p class="mt-1">{{ $product->click_count ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
