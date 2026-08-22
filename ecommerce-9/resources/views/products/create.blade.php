@extends('layouts.app2')
@section('title', 'Tambah Produk')
@section('content')<div class="max-w-2xl mx-auto rounded-lg bg-white p-6 shadow-sm"><h1 class="mb-6 text-2xl font-bold">Tambah Produk</h1>@include('products.form', ['action' => route('products.store'), 'method' => 'POST', 'product' => null])</div>@endsection