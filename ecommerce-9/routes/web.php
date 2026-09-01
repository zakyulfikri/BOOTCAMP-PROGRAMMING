<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkoutPage'])->middleware('auth')->name('checkout.page');
Route::post('/checkout', [CartController::class, 'checkout'])->middleware('auth')->name('checkout');

Route::get('/shop/products', [ShopController::class, 'products'])->name('shop.products');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');

    Route::get('/product-category/create', [ProductCategoryController::class, 'create'])->name('product-category.create');
    Route::post('/product-category', [ProductCategoryController::class, 'store'])->name('product-category.store');

    Route::resource('categories', ProductCategoryController::class)->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy',
    ]);
    Route::resource('products', ProductsController::class)->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy',
    ]);
});

Route::get('/products/{product}', [ProductsController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
