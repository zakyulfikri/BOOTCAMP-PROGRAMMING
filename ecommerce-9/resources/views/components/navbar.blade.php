<nav x-data="{ open: false }" class="border-b border-gray-200 bg-white text-black shadow-lg">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('dashboard') }}" class="text-2xl font-black tracking-tight text-black">Z Shop<span class="text-black">.</span></a>

        <div class="hidden items-center gap-2 md:flex">
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-red-600 text-black' : 'text-black hover:bg-red-50' }}">Dashboard</a>
            @endauth
            <a href="{{ route('categories.index') }}" class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('categories.*') ? 'bg-red-600 text-black' : 'text-black hover:bg-red-50' }}">Kategori</a>
            <a href="{{ route('products.index') }}" class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('products.*') ? 'bg-red-600 text-black' : 'text-black hover:bg-red-50' }}">Produk</a>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="ml-2">@csrf<button type="submit" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-black hover:border-red-600 hover:bg-red-50">Keluar</button></form>
            @endauth
        </div>

        <button type="button" @click="open = !open" class="rounded-lg p-2 text-black hover:bg-red-50 md:hidden" aria-label="Buka menu">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
        </button>
    </div>
    <div x-show="open" x-transition class="border-t border-gray-200 px-4 pb-4 md:hidden">
        <div class="mx-auto max-w-7xl space-y-1 pt-3">
            @auth<a href="{{ route('dashboard') }}" class="block rounded-lg px-4 py-3 font-semibold text-black hover:bg-red-50">Dashboard</a>@endauth
            <a href="{{ route('categories.index') }}" class="block rounded-lg px-4 py-3 font-semibold text-black hover:bg-red-50">Kategori</a>
            <a href="{{ route('products.index') }}" class="block rounded-lg px-4 py-3 font-semibold text-black hover:bg-red-50">Produk</a>
        </div>
    </div>
</nav>