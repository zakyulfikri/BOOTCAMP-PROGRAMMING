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

test('admin user can access admin routes', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/categories');

    $response->assertOk();
});
