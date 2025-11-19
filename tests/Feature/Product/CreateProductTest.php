<?php

use App\Models\User;

test('seller can create product', function () {
    $seller = User::factory()->create(['role' => 'seller']);

    $response = $this->actingAs($seller)
        ->postJson('/api/products', [
            'title' => 'Premium Road Bike',
            'description' => 'A high-quality road bike',
            'price' => 2500.00,
            'bike_type' => 'road',
            'frame_material' => 'carbon',
            'brake_type' => 'disc_brake_hydraulic',
            'wheel_size' => '700c',
            'brand' => 'Trek',
            'model' => 'Domane',
            'year' => 2023,
        ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'product' => [
                'id',
                'title',
                'price',
                'bike_type',
            ],
        ]);

    $this->assertDatabaseHas('products', [
        'title' => 'Premium Road Bike',
        'seller_id' => $seller->id,
        'status' => 'draft',
    ]);
});

test('non-seller cannot create product', function () {
    $buyer = User::factory()->create(['role' => 'buyer']);

    $response = $this->actingAs($buyer)
        ->postJson('/api/products', [
            'title' => 'Test Bike',
            'description' => 'Test',
            'price' => 1000,
            'bike_type' => 'road',
            'frame_material' => 'carbon',
            'brake_type' => 'rim_brake',
            'wheel_size' => '700c',
        ]);

    $response->assertStatus(403);
});

test('product creation requires all mandatory fields', function () {
    $seller = User::factory()->create(['role' => 'seller']);

    $response = $this->actingAs($seller)
        ->postJson('/api/products', [
            'title' => 'Test Bike',
            // Missing required fields
        ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['description', 'price', 'bike_type', 'frame_material', 'brake_type', 'wheel_size']);
});

