<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/products', function () {
    echo 'this is products';
});

Route::get('/cart', function () {
    echo 'this is cart';
});

Route::get('/checkout', function () {
    echo 'this is checkout';
});
