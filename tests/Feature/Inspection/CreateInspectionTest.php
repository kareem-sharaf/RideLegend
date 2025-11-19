<?php

use App\Models\User;
use App\Models\Product;

test('seller can request inspection', function () {
    $seller = User::factory()->create(['role' => 'seller']);
    $workshop = User::factory()->create(['role' => 'workshop']);
    $product = Product::factory()->create(['seller_id' => $seller->id]);

    $response = $this->actingAs($seller)
        ->postJson('/api/inspections', [
            'product_id' => $product->id,
            'workshop_id' => $workshop->id,
        ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'inspection' => [
                'id',
                'product_id',
                'status',
            ],
        ]);

    $this->assertDatabaseHas('inspections', [
        'product_id' => $product->id,
        'seller_id' => $seller->id,
        'workshop_id' => $workshop->id,
        'status' => 'pending',
    ]);
});

test('workshop can submit inspection report', function () {
    $workshop = User::factory()->create(['role' => 'workshop']);
    $inspection = \App\Models\Inspection::factory()->create([
        'workshop_id' => $workshop->id,
        'status' => 'in_progress',
    ]);

    $response = $this->actingAs($workshop)
        ->postJson("/api/inspections/{$inspection->id}/report", [
            'frame_grade' => 'excellent',
            'brake_grade' => 'very_good',
            'groupset_grade' => 'good',
            'wheels_grade' => 'excellent',
            'overall_grade' => 'A',
            'notes' => 'Overall condition is excellent',
        ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'inspection' => [
                'id',
                'status',
                'overall_grade',
            ],
        ]);

    $this->assertDatabaseHas('inspections', [
        'id' => $inspection->id,
        'status' => 'completed',
        'overall_grade' => 'A',
    ]);
});

