<?php

use App\Models\User;

test('non admin user cannot access admin routes', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/categories');

    $response->assertForbidden();
});

test('non admin user cannot access the dashboard', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/dashboard');

    $response->assertForbidden();
});

test('admin user can access admin routes', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/categories');

    $response->assertOk();
});

test('admin user can access product creation page', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/product/create');

    $response->assertOk();
});

test('admin user can access category creation page', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/product-category/create');

    $response->assertOk();
});

test('public home page is accessible without login', function () {
    $response = $this->get('/');

    $response->assertOk();
});
