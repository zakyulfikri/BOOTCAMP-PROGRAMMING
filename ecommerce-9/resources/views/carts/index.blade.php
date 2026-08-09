@extends('layouts.app2')

@section('title', 'Keranjang Belanja')

@section('content')
<h2 class="text-2xl font-bold mb-6">Keranjang Belanja</h2>
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b text-gray-600">
                <th class="pb-3">Produk</th>
                <th class="pb-3">Harga</th>
                <th class="pb-3">Jumlah</th>
                <th class="pb-3">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b">
                <td class="py-4">Contoh Produk Z Shop</td>
                <td class="py-4">Rp 150.000</td>
                <td class="py-4">1</td>
                <td class="py-4">Rp 150.000</td>
            </tr>
        </tbody>
    </table>
    <div class="mt-6 flex justify-end">
        <button class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700">Checkout</button>
    </div>
</div>
@endsection