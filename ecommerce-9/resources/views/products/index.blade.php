@extends('layouts.app2')

@section('title', 'Daftar Produk')

@section('content')
<h2 class="text-2xl font-bold mb-6">Daftar Produk</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($products ?? [] as $product)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
            {{-- Bagian Gambar Produk --}}
            <div class="h-48 w-full bg-gray-100 overflow-hidden">
                <img 
                    src="{{ $product->image ?? 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                    alt="{{ $product->name }}" 
                    class="w-full h-full object-cover"
                >
            </div>
            
            {{-- Detail Produk --}}
            <div class="p-4">
                <h3 class="font-bold text-lg mb-2 text-gray-800">{{ $product->name }}</h3>
                <p class="text-indigo-600 font-semibold mb-4">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
                <button class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">
                    Tambah ke Keranjang
                </button>
            </div>
        </div>
    @empty
        <p class="text-gray-500 col-span-full">Belum ada produk yang tersedia.</p>
    @endforelse
</div>
@endsection