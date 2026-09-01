@extends('layouts.app2')

@section('title', 'Semua Produk')

@section('content')
<div class="mx-auto max-w-7xl space-y-8 pb-10">
    <section class="overflow-hidden rounded-[32px] bg-gradient-to-br from-slate-950 via-slate-900 to-red-600 text-white shadow-[0_30px_80px_rgba(15,23,42,0.35)]">
        <div class="grid items-center gap-8 px-6 py-8 md:px-10 lg:grid-cols-[1.1fr_0.9fr] lg:px-12 lg:py-10">
            <div>
                <span class="inline-flex rounded-full border border-white/20 bg-white/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-red-100">New Collection</span>
                <h1 class="mt-5 text-4xl font-black leading-tight md:text-5xl">Produk pilihan untuk hidup yang lebih stylish.</h1>
                <p class="mt-4 max-w-xl text-base text-slate-200 md:text-lg">
                    Temukan item favorit Anda dengan kualitas premium, desain modern, dan pengalaman belanja yang lebih nyaman.
                </p>
                <div class="mt-6 flex flex-wrap gap-3 text-sm text-slate-200">
                    <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1.5">Gratis Ongkir</span>
                    <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1.5">Produk Original</span>
                    <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1.5">Cashback</span>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -left-8 top-8 h-28 w-28 rounded-full bg-red-400/40 blur-2xl"></div>
                <div class="absolute -right-6 bottom-6 h-32 w-32 rounded-full bg-orange-300/30 blur-2xl"></div>
                <div class="relative rounded-[28px] border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                    <img src="https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=900&q=80" alt="Produk premium" class="h-[350px] w-full rounded-[24px] object-cover">
                    <div class="absolute bottom-8 left-8 right-8 rounded-2xl bg-white/10 p-4 ring-1 ring-white/20 backdrop-blur-md">
                        <div class="flex items-center justify-between gap-3 text-white">
                            <div>
                                <p class="text-[10px] uppercase tracking-[0.2em] text-red-100">Trending</p>
                                <p class="mt-1 text-lg font-bold">Nova Streetwear</p>
                            </div>
                            <span class="rounded-full bg-white/10 px-2.5 py-1 text-sm font-semibold">Rp 299K</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-3">
        <div class="rounded-3xl border border-red-100 bg-white p-5 shadow-sm">
            <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-red-100 text-2xl">⚡</div>
            <h2 class="text-lg font-bold text-slate-900">Pengiriman Cepat</h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">Pesanan aman dan sampai dengan cepat ke rumah Anda.</p>
        </div>
        <div class="rounded-3xl border border-red-100 bg-white p-5 shadow-sm">
            <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-100 text-2xl">🛡️</div>
            <h2 class="text-lg font-bold text-slate-900">Kualitas Terjamin</h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">Setiap produk dipilih dengan kualitas terbaik dan siap pakai.</p>
        </div>
        <div class="rounded-3xl border border-red-100 bg-white p-5 shadow-sm">
            <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-2xl">💳</div>
            <h2 class="text-lg font-bold text-slate-900">Pembayaran Mudah</h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">Pilihan pembayaran yang fleksibel sesuai kebutuhan Anda.</p>
        </div>
    </section>

    <section class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-red-500">Catalog</p>
                <h2 class="mt-2 text-3xl font-black text-slate-900">Produk Kami</h2>
            </div>
            <div class="flex flex-wrap gap-2 text-sm">
                <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 font-medium text-slate-700">Terbaru</span>
                <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 font-medium text-slate-700">Best Seller</span>
                <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 font-medium text-slate-700">Promosi</span>
            </div>
        </div>

        @if ($products->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center shadow-sm">
                <h3 class="text-xl font-bold text-slate-900">Belum ada produk</h3>
                <p class="mt-2 text-slate-600">Produk baru akan muncul di sini.</p>
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($products as $product)
                    <article class="group overflow-hidden rounded-[26px] border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-64 w-full object-cover transition duration-300 group-hover:scale-105">
                            <span class="absolute left-4 top-4 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-900 shadow-sm">{{ $product->category->name ?? 'Umum' }}</span>
                        </div>
                        <div class="p-5">
                            <h3 class="line-clamp-2 text-lg font-bold text-slate-900">{{ $product->name }}</h3>
                            <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-600">{{ $product->description }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xl font-black text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="rounded-full bg-red-50 px-2.5 py-1 text-[11px] font-bold text-red-600">{{ $product->stock }} stok</span>
                            </div>
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('products.show', $product) }}" class="flex-1 rounded-xl border border-slate-200 px-3 py-2 text-center text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">Detail</a>
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full rounded-xl bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-lg shadow-red-200 transition hover:bg-red-700">Keranjang</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
@endsection
