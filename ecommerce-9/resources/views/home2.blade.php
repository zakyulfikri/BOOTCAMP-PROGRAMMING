@extends('layouts.app2')

@section('title', 'Selamat Datang')

@section('content')
<div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200 mb-8 text-black">
    <h1 class="text-4xl font-extrabold text-black mb-4">Selamat Datang di Z Shop</h1>
    <p class="text-black text-lg mb-6">Temukan berbagai produk pilihan berkualitas dengan harga terbaik.</p>
    <a href="{{ route('products.index') }}" class="bg-red-600 text-black px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition">Lihat Katalog Produk</a>
</div>
@endsection