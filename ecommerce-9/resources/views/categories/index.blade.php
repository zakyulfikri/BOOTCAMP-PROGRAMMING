@extends('layouts.app2')
@section('title', 'Daftar Kategori')
@section('content')
<div class="mx-auto max-w-5xl">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"><div><p class="mb-1 text-sm font-semibold uppercase tracking-wider text-black">Katalog</p><h1 class="text-3xl font-black tracking-tight text-black">Kategori Produk</h1><p class="mt-1 text-black">Kelola kelompok produk di toko kamu.</p></div><a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 font-bold text-black shadow-sm transition hover:bg-red-700">+ Tambah Kategori</a></div>
    @if (session('success'))<div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 font-medium text-black">{{ session('success') }}</div>@endif
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"><table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-100 text-left text-xs uppercase tracking-wider text-black"><tr><th class="px-5 py-4">ID</th><th class="px-5 py-4">Nama Kategori</th><th class="px-5 py-4">Jumlah Produk</th><th class="px-5 py-4">Aksi</th></tr></thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($categories as $category)<tr class="transition hover:bg-red-50"><td class="px-5 py-4 text-black">#{{ $category->id }}</td><td class="px-5 py-4 font-bold text-black">{{ $category->name }}</td><td class="px-5 py-4"><span class="rounded-full bg-red-50 px-3 py-1 font-bold text-black">{{ $category->products_count }} produk</span></td><td class="whitespace-nowrap px-5 py-4"><a href="{{ route('categories.edit', $category) }}" class="mr-3 font-semibold text-black hover:text-black">Edit</a><form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">@csrf @method('DELETE')<button type="submit" class="font-semibold text-black hover:text-black">Hapus</button></form></td></tr>
            @empty<tr><td colspan="4" class="px-4 py-8 text-center text-black">Belum ada kategori.</td></tr>@endforelse
        </tbody>
    </table></div>
    <div class="mt-6">{{ $categories->links() }}</div>
</div>
@endsection