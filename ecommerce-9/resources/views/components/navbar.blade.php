<nav class="bg-indigo-600 text-white shadow-md">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('home2') }}" class="text-2xl font-bold tracking-wide">Z Shop</a>
        <div class="space-x-6 flex items-center">
            <a href="{{ route('home2') }}" class="hover:text-indigo-200 font-medium">Halaman Utama</a>
            <a href="{{ route('products.index') }}" class="hover:text-indigo-200 font-medium">Daftar Produk</a>
            <a href="{{ route('carts.index') }}" class="relative hover:text-indigo-200 font-medium">
                Keranjang
                <span class="bg-red-500 text-xs px-2 py-0.5 rounded-full text-white ml-1">0</span>
            </a>
        </div>
    </div>
</nav>