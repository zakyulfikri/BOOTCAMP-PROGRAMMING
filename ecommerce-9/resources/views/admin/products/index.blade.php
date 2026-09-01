@extends('layouts.app2')

@section('title', 'Daftar Produk')

@section('content')
<div class="mx-auto max-w-6xl">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-1 text-sm font-semibold uppercase tracking-wider text-black">Inventory</p>
            <h1 class="text-3xl font-black tracking-tight text-black">Daftar Produk</h1>
            <p class="mt-1 text-black">Kelola stok, harga, dan katalog produk toko kamu.</p>
        </div>
        <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 font-bold text-black shadow-sm transition hover:bg-red-700">+ Tambah Produk</a>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 font-medium text-black">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-left text-xs uppercase tracking-wider text-black">
                <tr>
                    <th class="px-5 py-4">ID</th>
                    <th class="px-5 py-4">Nama</th>
                    <th class="px-5 py-4">Kategori</th>
                    <th class="px-5 py-4">Stok</th>
                    <th class="px-5 py-4">Harga</th>
                    <th class="px-5 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($products as $product)
                    <tr class="transition hover:bg-red-50">
                        <td class="px-5 py-4 text-black">#{{ $product->id }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-12 w-12 rounded-lg border border-gray-200 object-cover">
                                <div>
                                    <p class="font-bold text-black">{{ $product->name }}</p>
                                    <p class="text-xs text-black">{{ Str::limit($product->description, 40) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-black">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-5 py-4"><span class="rounded-full {{ $product->stock > 0 ? 'bg-red-50' : 'bg-gray-200' }} px-3 py-1 font-bold text-black">{{ $product->stock }}</span></td>
                        <td class="whitespace-nowrap px-5 py-4 font-semibold text-black">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="whitespace-nowrap px-5 py-4">
                            <a href="{{ route('products.edit', $product) }}" class="mr-3 font-semibold text-black hover:text-black">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-semibold text-black hover:text-black">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-black">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $products->links() }}</div>
</div>
@endsection
