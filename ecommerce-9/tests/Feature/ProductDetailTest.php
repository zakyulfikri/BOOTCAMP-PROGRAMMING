<?php

use App\Models\ProductCategory;
use App\Models\Products;

it('shows the product detail page', function () {
    $category = ProductCategory::create([
        'name' => 'Elektronik',
        'slug' => 'elektronik',
    ]);

    $product = Products::create([
        'name' => 'Laptop Gaming',
        'slug' => 'laptop-gaming',
        'description' => 'Laptop untuk gaming dan kerja',
        'image' => 'storage/products/laptop.jpg',
        'stock' => 8,
        'price' => 15000000,
        'product_category_id' => $category->id,
        'click_count' => 20,
    ]);

    $response = $this->get(route('products.show', $product));

    $response->assertOk();
    $response->assertSeeText('Laptop Gaming');
    $response->assertSeeText('Laptop untuk gaming dan kerja');
    $response->assertSeeText('Rp 15.000.000');
});
