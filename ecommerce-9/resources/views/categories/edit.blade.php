@extends('layouts.app2')
@section('title', 'Edit Kategori')
@section('content')
<div class="max-w-xl mx-auto rounded-lg bg-white p-6 shadow-sm"><h1 class="mb-6 text-2xl font-bold">Edit Kategori</h1>
    @include('categories.form', ['action' => route('categories.update', $category), 'method' => 'PUT', 'category' => $category])
</div>
@endsection