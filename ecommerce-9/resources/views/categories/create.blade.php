@extends('layouts.app2')
@section('title', 'Tambah Kategori')
@section('content')
<div class="mx-auto max-w-2xl overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-xl shadow-slate-200/60"><div class="border-b border-slate-100 bg-slate-950 px-6 py-7 text-white sm:px-10"><p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-red-400">Katalog · Kategori</p><h1 class="text-3xl font-black tracking-tight">Tambah kategori</h1><p class="mt-2 max-w-lg text-sm leading-6 text-slate-300">Buat pengelompokan baru agar produk lebih mudah ditemukan.</p></div><div class="p-6 sm:p-10">
    @include('categories.form', ['action' => route('product-category.store'), 'method' => 'POST', 'category' => null])
</div></div>
@endsection