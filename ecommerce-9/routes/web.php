<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductsController;

Route::get('/', [ShopController::class, 'home'])->name('home2');
Route::get('/products', [ShopController::class, 'products'])->name('products.index');
Route::get('/carts', [ShopController::class, 'carts'])->name('carts.index');
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');