@extends('layouts.app2')

@section('title', 'Z Shop | Belanja Produk Terbaik')

@section('content')
    <div class="space-y-8 pb-6">
        <section class="overflow-hidden rounded-[32px] bg-gradient-to-br from-slate-950 via-slate-900 to-red-600 text-white shadow-[0_30px_80px_rgba(15,23,42,0.35)]">
            <div class="grid items-center gap-10 px-6 py-10 md:px-10 lg:grid-cols-[1.2fr_0.8fr] lg:px-14 lg:py-16">
                <div>
                    <span class="inline-flex rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-red-100">New Season</span>
                    <h1 class="mt-5 text-4xl font-black leading-tight md:text-5xl lg:text-6xl">Temukan style baru untuk hari Anda.</h1>
                    <p class="mt-5 max-w-xl text-base text-slate-200 md:text-lg">
                        Koleksi produk unggulan dengan kualitas terbaik, desain modern, dan harga yang ramah di kantong.
                    </p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('shop.products') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-sm font-bold text-slate-900 transition hover:bg-red-50">Lihat Produk</a>
                        @if (! auth()->check())
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full border border-white/30 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10">Login</a>
                        @endif
                        @if (auth()->check() && auth()->user()->role === 'admin')
                            <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center rounded-full border border-white/30 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10">Kategori</a>
                        @endif
                    </div>
                    <div class="mt-8 flex flex-wrap gap-5 text-sm text-slate-200">
                        <div><span class="block text-2xl font-black text-white">5K+</span> Pelanggan</div>
                        <div><span class="block text-2xl font-black text-white">120+</span> Produk</div>
                        <div><span class="block text-2xl font-black text-white">4.9/5</span> Rating</div>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute -left-8 top-8 h-28 w-28 rounded-full bg-red-400/40 blur-2xl"></div>
                    <div class="absolute -right-6 bottom-6 h-32 w-32 rounded-full bg-orange-300/30 blur-2xl"></div>
                    <div class="relative rounded-[28px] border border-white/10 bg-white/10 p-4 shadow-2xl backdrop-blur-sm">
                        <img src="https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=900&q=80" alt="Produk unggulan" class="h-[420px] w-full rounded-[24px] object-cover">
                        <div class="absolute bottom-8 left-8 right-8 rounded-2xl bg-white/10 p-4 backdrop-blur-md ring-1 ring-white/20">
                            <p class="text-xs uppercase tracking-[0.2em] text-red-100">Featured</p>
                            <div class="mt-2 flex items-center justify-between text-white">
                                <span class="text-lg font-bold">Nova Streetwear</span>
                                <span class="rounded-full bg-white/15 px-2.5 py-1 text-sm font-semibold">Rp 299K</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-red-100 bg-white p-5 shadow-sm">
                <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-red-100 text-2xl">🚚</div>
                <h3 class="text-lg font-bold text-slate-900">Pengiriman Cepat</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">Layanan kirim yang cepat dan aman ke seluruh wilayah.</p>
            </div>
            <div class="rounded-3xl border border-red-100 bg-white p-5 shadow-sm">
                <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-100 text-2xl">🛡️</div>
                <h3 class="text-lg font-bold text-slate-900">Produk Original</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">Setiap item dipilih dengan kualitas yang terjamin.</p>
            </div>
            <div class="rounded-3xl border border-red-100 bg-white p-5 shadow-sm">
                <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-2xl">💳</div>
                <h3 class="text-lg font-bold text-slate-900">Pembayaran Mudah</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">Transaksi aman dengan berbagai metode pembayaran.</p>
            </div>
        </section>

        <section>
            <div class="mb-6 flex items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-red-500">Kategori</p>
                    <h2 class="mt-2 text-3xl font-black text-slate-900">Jelajahi Kategori</h2>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($categories as $category)
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-red-100 text-xl">📦</div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $category->name }}</h3>
                        <p class="mt-2 text-sm text-slate-500">{{ $category->products_count }} produk tersedia</p>
                    </div>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-6 text-slate-500">Belum ada kategori.</div>
                @endforelse
            </div>
        </section>

        <section class="pt-2">
            <div class="mb-6 flex items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-red-500">Featured</p>
                    <h2 class="mt-2 text-3xl font-black text-slate-900">Produk Pilihan</h2>
                </div>
                <a href="{{ route('shop.products') }}" class="hidden text-sm font-bold text-red-600 hover:text-red-700 sm:inline-flex">Lihat semua →</a>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                @forelse ($featuredProducts as $product)
                    <article class="overflow-hidden rounded-[26px] border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-64 w-full object-cover">
                            <span class="absolute left-4 top-4 rounded-full bg-white/90 px-2.5 py-1 text-xs font-bold text-slate-900 shadow-sm">{{ $product->category->name ?? 'Umum' }}</span>
                        </div>
                        <div class="p-5">
                            <h3 class="line-clamp-2 text-lg font-bold text-slate-900">{{ $product->name }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-600">{{ $product->description }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xl font-black text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-bold text-red-600">{{ $product->stock }} stok</span>
                            </div>
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('products.show', $product) }}" class="flex-1 rounded-xl border border-slate-200 px-3 py-2 text-center text-sm font-semibold text-slate-700 hover:border-slate-300 hover:bg-slate-50">Detail</a>
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full rounded-xl bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-lg shadow-red-200 transition hover:bg-red-700">Keranjang</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-6 text-slate-500 sm:col-span-2 xl:col-span-4">Belum ada produk untuk ditampilkan.</div>
                @endforelse
            </div>
        </section>
    </div>
@endsection