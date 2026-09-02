@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp

<nav x-data="{ open: false }" @keydown.escape.window="open = false" class="sticky top-0 z-50 border-b border-red-100 bg-white/80 shadow-[0_10px_30px_rgba(15,23,42,0.05)] backdrop-blur-xl">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ $isAdmin ? route('dashboard') : route('home') }}" class="inline-flex items-center gap-2 text-2xl font-black tracking-tight text-slate-900">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-orange-400 text-lg text-white shadow-lg shadow-red-200">Z</span>
            <span>Z <span class="text-red-500">Shop</span></span>
        </a>

        <div class="hidden items-center gap-2 md:flex">
            @if ($isAdmin)
                <a href="{{ route('dashboard') }}" class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-red-500 to-orange-400 text-white shadow-lg shadow-red-200' : 'text-slate-700 hover:bg-red-50 hover:text-red-600' }}">Dashboard</a>
                <a href="{{ route('categories.index') }}" class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('categories.*') ? 'bg-gradient-to-r from-red-500 to-orange-400 text-white shadow-lg shadow-red-200' : 'text-slate-700 hover:bg-red-50 hover:text-red-600' }}">Kategori</a>
                <a href="{{ route('products.index') }}" class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('products.*') ? 'bg-gradient-to-r from-red-500 to-orange-400 text-white shadow-lg shadow-red-200' : 'text-slate-700 hover:bg-red-50 hover:text-red-600' }}">Produk</a>
            @else
                <a href="{{ route('shop.products') }}" class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('shop.products') ? 'bg-gradient-to-r from-red-500 to-orange-400 text-white shadow-lg shadow-red-200' : 'text-slate-700 hover:bg-red-50 hover:text-red-600' }}">Produk</a>
            @endif

            @if (! $isAdmin)
                <a href="{{ route('cart.index') }}" class="rounded-xl bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-100">
                    Keranjang
                    <span class="ml-1 inline-flex min-w-6 items-center justify-center rounded-full bg-red-600 px-1.5 py-0.5 text-[10px] font-bold text-white">
                        {{ collect(session('cart', []))->sum('quantity') }}
                    </span>
                </a>
            @endif

            @guest
                <a href="{{ route('login') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-red-300 hover:bg-red-50 hover:text-red-600">Login</a>
            @endguest

            @auth
                <form method="POST" action="{{ route('logout') }}" class="ml-2">@csrf<button type="submit" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-red-300 hover:bg-red-50 hover:text-red-600">Keluar</button></form>
            @endauth
        </div>

        <button type="button" @click="open = !open" :aria-expanded="open" aria-controls="mobile-menu" class="relative rounded-xl border border-slate-200 bg-white p-2 text-slate-700 shadow-sm transition hover:border-red-200 hover:text-red-600 focus:outline-none focus:ring-4 focus:ring-red-100 md:hidden" :aria-label="open ? 'Tutup menu' : 'Buka menu'">
            <svg x-show="!open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18" /></svg>
        </button>
    </div>
    <div x-show="open" x-cloak x-transition.opacity @click.outside="open = false" class="fixed inset-x-0 top-[73px] z-40 border-t border-slate-200 bg-white/95 px-4 pb-4 shadow-xl backdrop-blur-xl md:hidden" id="mobile-menu">
        <div class="mx-auto max-w-7xl space-y-1 pt-3">
            @if ($isAdmin)
                <a @click="open = false" href="{{ route('dashboard') }}" class="block rounded-xl px-4 py-3 font-semibold text-slate-700 transition hover:bg-red-50 hover:text-red-600">Dashboard</a>
                <a @click="open = false" href="{{ route('categories.index') }}" class="block rounded-xl px-4 py-3 font-semibold text-slate-700 transition hover:bg-red-50 hover:text-red-600">Kategori</a>
                <a @click="open = false" href="{{ route('products.index') }}" class="block rounded-xl px-4 py-3 font-semibold text-slate-700 transition hover:bg-red-50 hover:text-red-600">Produk</a>
            @else
                <a @click="open = false" href="{{ route('shop.products') }}" class="block rounded-xl px-4 py-3 font-semibold text-slate-700 transition hover:bg-red-50 hover:text-red-600">Produk</a>
            @endif
            @if (! $isAdmin)
                <a @click="open = false" href="{{ route('cart.index') }}" class="flex items-center justify-between rounded-xl px-4 py-3 font-semibold text-slate-700 transition hover:bg-red-50 hover:text-red-600">
                    <span>Keranjang</span>
                    <span class="inline-flex min-w-7 items-center justify-center rounded-full bg-red-100 px-2 py-1 text-xs font-bold text-red-600">{{ collect(session('cart', []))->sum('quantity') }}</span>
                </a>
            @endif
            @guest
                <a @click="open = false" href="{{ route('login') }}" class="block rounded-xl px-4 py-3 font-semibold text-slate-700 transition hover:bg-red-50 hover:text-red-600">Login</a>
            @endguest
            @auth
                <form method="POST" action="{{ route('logout') }}" class="pt-1">@csrf<button type="submit" class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-left font-semibold text-slate-700 hover:border-red-300 hover:bg-red-50 hover:text-red-600">Keluar</button></form>
            @endauth
        </div>
    </div>
</nav>