<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Halaman Utama
    public function home()
    {
        return view('home2');
    }

    // Daftar Produk
    public function products()
    {
        // Contoh data dummy produk (nantinya bisa diambil dari Database)
        $products = [
            (object)[
                'name' => 'Kaos Z Shop', 
                'price' => 120000,
                'image' => 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=500&auto=format&fit=crop&q=60](https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=500&auto=format&fit=crop&q=60'
            ],
            (object)[
                'name' => 'Jaket Z Shop', 
                'price' => 250000,
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=500&auto=format&fit=crop&q=60'
            ],
            (object)[
                'name' => 'Topi Z Shop', 
                'price' => 75000,
                'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=500&auto=format&fit=crop&q=60'
            ],
        ];

        return view('products.index', compact('products'));
    }

    // Halaman Keranjang
    public function carts()
    {
        return view('carts.index');
    }
}