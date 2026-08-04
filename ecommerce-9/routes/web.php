<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo 'this is home';
});

Route::get('/products', function () {
    echo 'this is products';
});

Route::get('/cart', function () {
    echo 'this is cart';
});

Route::get('/checkout', function () {
    echo 'this is checkout';
});