<?php

use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\Products;
use App\Models\User;

it('shows dashboard summary statistics', function () {
    $user = User::factory()->create();

    ProductCategory::create([
        'name' => 'Elektronik',
        'slug' => 'elektronik',
    ]);

    ProductCategory::create([
        'name' => 'Pakaian',
        'slug' => 'pakaian',
    ]);

    Products::create([
        'name' => 'Laptop',
        'slug' => 'laptop',
        'description' => 'Laptop gaming',
        'image' => 'storage/products/laptop.jpg',
        'stock' => 5,
        'price' => 12000000,
        'product_category_id' => 1,
        'click_count' => 42,
    ]);

    Products::create([
        'name' => 'Kaos',
        'slug' => 'kaos',
        'description' => 'Kaos premium',
        'image' => 'storage/products/kaos.jpg',
        'stock' => 10,
        'price' => 150000,
        'product_category_id' => 2,
        'click_count' => 18,
    ]);

    Order::create([
        'order_number' => 'ORD-001',
        'customer_name' => 'Ali',
        'customer_phone' => '081234567890',
        'customer_address' => 'Jakarta',
        'total_amount' => 100000,
        'status' => 'pending',
        'payment_method' => 'transfer',
        'user_id' => $user->id,
    ]);

    Order::create([
        'order_number' => 'ORD-002',
        'customer_name' => 'Budi',
        'customer_phone' => '081234567891',
        'customer_address' => 'Bandung',
        'total_amount' => 250000,
        'status' => 'completed',
        'payment_method' => 'cod',
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
    $response->assertViewHas('stats');
    $response->assertViewHas('categoryChart');
    $response->assertViewHas('weeklyOrders');
    $response->assertViewHas('recentOrders');
    $response->assertSeeText('Jumlah Produk');
    $response->assertSeeText('2');
    $response->assertSeeText('Jumlah Kategori Produk');
    $response->assertSeeText('2');
    $response->assertSeeText('Jumlah Klik Produk');
    $response->assertSeeText('60');
    $response->assertSeeText('Jumlah Order');
    $response->assertSeeText('2');
    $response->assertSeeText('ORD-001');
    $response->assertSeeText('ORD-002');
});
