<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Road Bikes',
                'slug' => 'road-bikes',
                'description' => 'Lightweight bikes designed for speed on paved roads',
            ],
            [
                'name' => 'Mountain Bikes',
                'slug' => 'mountain-bikes',
                'description' => 'Durable bikes built for off-road trails and rugged terrain',
            ],
            [
                'name' => 'Electric Bikes',
                'slug' => 'electric-bikes',
                'description' => 'Motor-assisted bicycles for easier riding',
            ],
            [
                'name' => 'Gravel Bikes',
                'slug' => 'gravel-bikes',
                'description' => 'Versatile bikes for mixed terrain adventures',
            ],
            [
                'name' => 'Hybrid Bikes',
                'slug' => 'hybrid-bikes',
                'description' => 'Comfortable bikes for commuting and leisure',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}

