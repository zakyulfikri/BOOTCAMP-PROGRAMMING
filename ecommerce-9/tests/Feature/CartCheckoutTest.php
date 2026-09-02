<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductCategory;
use App\Models\Products;
use App\Models\User;

it('shows a dedicated checkout page before processing the order', function () {
    $user = User::factory()->create();

    $category = ProductCategory::create([
        'name' => 'Elektronik',
        'slug' => 'elektronik',
    ]);

    $product = Products::create([
        'name' => 'Laptop Asus',
        'slug' => 'laptop-asus',
        'description' => 'Laptop untuk kerja dan belajar',
        'image' => 'storage/products/laptop.jpg',
        'stock' => 10,
        'price' => 12000000,
        'product_category_id' => $category->id,
        'click_count' => 15,
    ]);

    $checkoutPageResponse = $this->actingAs($user)->withSession([
        'cart' => [
            $product->id => [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ],
        ],
    ])->get('/checkout');

    $checkoutPageResponse->assertOk();
    $checkoutPageResponse->assertSeeText('Checkout');
    $checkoutPageResponse->assertSeeText('Laptop Asus');
});

it('adds product to cart and creates order from checkout', function () {
    $user = User::factory()->create();

    $category = ProductCategory::create([
        'name' => 'Elektronik',
        'slug' => 'elektronik',
    ]);

    $product = Products::create([
        'name' => 'Laptop Asus',
        'slug' => 'laptop-asus',
        'description' => 'Laptop untuk kerja dan belajar',
        'image' => 'storage/products/laptop.jpg',
        'stock' => 10,
        'price' => 12000000,
        'product_category_id' => $category->id,
        'click_count' => 15,
    ]);

    $addResponse = $this->post(route('cart.add', $product));
    $addResponse->assertRedirect('/');
    expect(session('cart.'.$product->id.'.product_id'))->toBe($product->id);

    $cartResponse = $this->actingAs($user)->withSession([
        'cart' => [
            $product->id => [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ],
        ],
    ])->get('/cart');

    $cartResponse->assertOk();
    $cartResponse->assertSeeText('Laptop Asus');

    $checkoutResponse = $this->actingAs($user)->withSession([
        'cart' => [
            $product->id => [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ],
        ],
    ])->post('/checkout', [
        'customer_name' => 'Andi',
        'customer_phone' => '081234567890',
        'customer_address' => 'Jakarta',
        'payment_method' => 'transfer',
    ]);

    $checkoutResponse->assertRedirectContains('https://wa.me/');
    $this->assertDatabaseHas('orders', [
        'customer_name' => 'Andi',
        'payment_method' => 'transfer',
    ]);
    $this->assertDatabaseHas('order_items', [
        'product_id' => $product->id,
        'quantity' => 1,
    ]);
    $this->assertEquals(1, OrderItem::count());
    $this->assertEquals(12000000, Order::latest()->first()->total_amount);
    $this->assertEquals(9, $product->fresh()->stock);
});

it('redirects to whatsapp with the order confirmation message', function () {
    config(['services.whatsapp.number' => '0812-3456-7890']);

    $user = User::factory()->create();
    $category = ProductCategory::create([
        'name' => 'Elektronik',
        'slug' => 'elektronik',
    ]);
    $product = Products::create([
        'name' => 'Laptop Asus',
        'slug' => 'laptop-asus',
        'description' => 'Laptop untuk kerja dan belajar',
        'image' => 'storage/products/laptop.jpg',
        'stock' => 10,
        'price' => 12000000,
        'product_category_id' => $category->id,
        'click_count' => 15,
    ]);

    $response = $this->actingAs($user)->withSession([
        'cart' => [
            $product->id => [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ],
        ],
    ])->post(route('checkout'), [
        'customer_name' => 'Andi',
        'customer_phone' => '081234567890',
        'customer_address' => 'Jakarta',
        'payment_method' => 'transfer',
    ]);

    $order = Order::latest()->first();

    $response->assertRedirect('https://wa.me/6281234567890?text='.rawurlencode(implode("\n", [
        'Halo, saya ingin mengonfirmasi pesanan.',
        '',
        'Nomor pesanan: '.$order->order_number,
        'Nama: Andi',
        'Total: Rp 12.000.000',
        'Metode pembayaran: transfer',
    ])));
    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'status' => 'completed',
    ]);
});
