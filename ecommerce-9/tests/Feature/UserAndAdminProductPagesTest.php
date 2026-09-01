<?php

use App\Models\ProductCategory;
use App\Models\Products;
use App\Models\User;

it('shows the public products page for users', function () {
    $category = ProductCategory::create([
        'name' => 'Elektronik',
        'slug' => 'elektronik',
    ]);

    $product = Products::create([
        'name' => 'Headphone Wireless',
        'slug' => 'headphone-wireless',
        'description' => 'Headphone dengan kualitas suara mantap',
        'image' => 'storage/products/headphone.jpg',
        'stock' => 12,
        'price' => 750000,
        'product_category_id' => $category->id,
        'click_count' => 5,
    ]);

    $response = $this->get(route('shop.products'));

    $response->assertOk();
    $response->assertSeeText('Headphone Wireless');
    $response->assertSeeText('Semua Produk');
});

it('shows different navigation for regular users and admins', function () {
    $user = User::factory()->create(['role' => 'user']);
    $admin = User::factory()->create(['role' => 'admin']);

    $userResponse = $this->actingAs($user)->get(route('shop.products'));
    $userResponse->assertOk();
    $userResponse->assertSeeText('Keranjang');
    $userResponse->assertDontSee(route('categories.index'));

    $adminResponse = $this->actingAs($admin)->get(route('products.index'));
    $adminResponse->assertOk();
    $adminResponse->assertSee(route('dashboard'));
    $adminResponse->assertSee(route('categories.index'));
});

it('shows the admin add product form', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    ProductCategory::create([
        'name' => 'Elektronik',
        'slug' => 'elektronik',
    ]);

    $response = $this->actingAs($admin)->get(route('products.create'));

    $response->assertOk();
    $response->assertSeeText('Tambah Produk');
    $response->assertSeeText('Nama produk');
});

it('keeps the admin products page with crud actions available', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $category = ProductCategory::create([
        'name' => 'Elektronik',
        'slug' => 'elektronik',
    ]);

    Products::create([
        'name' => 'Monitor 24 Inch',
        'slug' => 'monitor-24-inch',
        'description' => 'Monitor untuk kerja dan hiburan',
        'image' => 'storage/products/monitor.jpg',
        'stock' => 9,
        'price' => 1800000,
        'product_category_id' => $category->id,
        'click_count' => 7,
    ]);

    $response = $this->actingAs($admin)->get(route('products.index'));

    $response->assertOk();
    $response->assertSeeText('Daftar Produk');
    $response->assertSeeText('Tambah Produk');
});
