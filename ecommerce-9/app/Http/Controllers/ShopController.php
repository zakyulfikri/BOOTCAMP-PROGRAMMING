<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Products;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Halaman Utama
    public function home()
    {
        $featuredProducts = Products::with('category')->latest()->take(4)->get();
        $categories = ProductCategory::withCount('products')->get();

        return view('home2', compact('featuredProducts', 'categories'));
    }

    // Daftar Produk
    public function products()
    {
        $products = Products::with('category')->latest()->paginate(12);

        return view('products.index', compact('products'));
    }

    // Halaman Keranjang
    public function carts()
    {
        return view('carts.index');
    }
}