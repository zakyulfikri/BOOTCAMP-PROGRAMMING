@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp

<footer class="mt-auto border-t border-red-100 bg-slate-950 text-slate-300">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="mb-2 inline-flex items-center gap-2 text-xl font-black text-white">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-red-500 to-orange-400 text-sm text-white">Z</span>
                    Z Shop
                </div>
                <p class="max-w-md text-sm text-slate-400">Belanja produk favorit Anda dengan pengalaman yang lebih cepat, aman, dan nyaman.</p>
            </div>

            <div class="flex flex-wrap items-center gap-4 text-sm text-slate-300">
                <a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a>
                <a href="{{ route('shop.products') }}" class="transition hover:text-white">Produk</a>
                @if ($isAdmin)
                    <a href="{{ route('categories.index') }}" class="transition hover:text-white">Kategori</a>
                    <a href="{{ route('dashboard') }}" class="transition hover:text-white">Dashboard</a>
                @endif
            </div>
        </div>

        <div class="mt-8 border-t border-slate-800 pt-5 text-center text-sm text-slate-400">
            &copy; {{ date('Y') }} Z Shop. All rights reserved.
        </div>
    </div>
</footer>