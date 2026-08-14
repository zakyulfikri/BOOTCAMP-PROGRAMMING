@extends('layouts.app2')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Daftar Produk</h2>

    {{-- Grid Produk --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products ?? [] as $product)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col justify-between">
                
                {{-- Bagian Gambar Produk --}}
                <div class="h-48 w-full bg-gray-100 overflow-hidden">
                    <img 
                        src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                        alt="{{ $product->name }}" 
                        class="w-full h-full object-cover"
                        onerror="this.onerror=null;this.src='https://via.placeholder.com/300x200?text=No+Image';"
                    >
                </div>
                
                {{-- Detail Produk --}}
                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        {{-- Kategori Produk (Relasi ProductCategory) --}}
                        @if(isset($product->category))
                            <span class="inline-block bg-indigo-50 text-indigo-700 text-xs px-2 py-1 rounded-md font-semibold mb-2">
                                {{ $product->category->name }}
                            </span>
                        @endif

                        <h3 class="font-bold text-lg mb-1 text-gray-800 line-clamp-1">{{ $product->name }}</h3>
                        <p class="text-indigo-600 font-semibold mb-4">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>

                    <button class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">
                        Tambah ke Keranjang
                    </button>
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-full text-center py-8">Belum ada produk yang tersedia.</p>
        @endforelse
    </div>

    {{-- Link Pagination --}}
    @if(isset($products) && method_exists($products, 'links'))
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection