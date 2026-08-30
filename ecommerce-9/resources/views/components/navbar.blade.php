<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-red-100 bg-white/80 shadow-[0_10px_30px_rgba(15,23,42,0.05)] backdrop-blur-xl">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-2xl font-black tracking-tight text-slate-900">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-orange-400 text-lg text-white shadow-lg shadow-red-200">Z</span>
            <span>Z <span class="text-red-500">Shop</span></span>
        </a>

        <div class="hidden items-center gap-2 md:flex">
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-red-500 to-orange-400 text-white shadow-lg shadow-red-200' : 'text-slate-700 hover:bg-red-50 hover:text-red-600' }}">Dashboard</a>
            @endauth
            <a href="{{ route('categories.index') }}" class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('categories.*') ? 'bg-gradient-to-r from-red-500 to-orange-400 text-white shadow-lg shadow-red-200' : 'text-slate-700 hover:bg-red-50 hover:text-red-600' }}">Kategori</a>
            <a href="{{ route('products.index') }}" class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('products.*') ? 'bg-gradient-to-r from-red-500 to-orange-400 text-white shadow-lg shadow-red-200' : 'text-slate-700 hover:bg-red-50 hover:text-red-600' }}">Produk</a>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="ml-2">@csrf<button type="submit" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-red-300 hover:bg-red-50 hover:text-red-600">Keluar</button></form>
            @endauth
        </div>

        <button type="button" @click="open = !open" class="rounded-xl border border-slate-200 bg-white p-2 text-slate-700 shadow-sm transition hover:border-red-200 hover:text-red-600 md:hidden" aria-label="Buka menu">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
        </button>
    </div>
    <div x-show="open" x-transition class="border-t border-slate-200 bg-white/90 px-4 pb-4 md:hidden">
        <div class="mx-auto max-w-7xl space-y-1 pt-3">
            @auth<a href="{{ route('dashboard') }}" class="block rounded-xl px-4 py-3 font-semibold text-slate-700 hover:bg-red-50 hover:text-red-600">Dashboard</a>@endauth
            <a href="{{ route('categories.index') }}" class="block rounded-xl px-4 py-3 font-semibold text-slate-700 hover:bg-red-50 hover:text-red-600">Kategori</a>
            <a href="{{ route('products.index') }}" class="block rounded-xl px-4 py-3 font-semibold text-slate-700 hover:bg-red-50 hover:text-red-600">Produk</a>
        </div>
    </div>
</nav>