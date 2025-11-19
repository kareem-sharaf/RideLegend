<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Inspection;

test('workshop can generate certification after inspection completion', function () {
    $workshop = User::factory()->create(['role' => 'workshop']);
    $product = Product::factory()->create();
    $inspection = Inspection::factory()->create([
        'product_id' => $product->id,
        'workshop_id' => $workshop->id,
        'status' => 'completed',
        'overall_grade' => 'A',
    ]);

    $response = $this->actingAs($workshop)
        ->postJson('/api/certifications/generate', [
            'product_id' => $product->id,
            'inspection_id' => $inspection->id,
            'workshop_id' => $workshop->id,
            'grade' => 'A',
        ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'certification' => [
                'id',
                'product_id',
                'grade',
                'report_url',
            ],
        ]);

    $this->assertDatabaseHas('certifications', [
        'product_id' => $product->id,
        'inspection_id' => $inspection->id,
        'grade' => 'A',
    ]);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'certification_id' => $response->json('certification.id'),
    ]);
});

