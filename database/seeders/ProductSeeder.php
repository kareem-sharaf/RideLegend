<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = User::where('role', 'seller')->get();
        $categories = ProductCategory::all();

        if ($sellers->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('Please run UserSeeder and ProductCategorySeeder first!');
            return;
        }

        // Realistic bike data
        $bikes = [
            // Road Bikes
            [
                'title' => 'Specialized Tarmac SL7 Pro',
                'description' => 'Professional-grade road bike with carbon frame and Shimano Dura-Ace groupset. Lightweight and aerodynamic design perfect for racing and long-distance rides.',
                'price' => 8499.99,
                'bike_type' => 'road',
                'frame_material' => 'carbon',
                'brake_type' => 'disc_brake_hydraulic',
                'wheel_size' => '700c',
                'weight' => 7.2,
                'weight_unit' => 'kg',
                'brand' => 'Specialized',
                'model' => 'Tarmac SL7 Pro',
                'year' => 2023,
                'status' => 'active',
                'category_slug' => 'road-bikes',
            ],
            [
                'title' => 'Trek Domane SL 7',
                'description' => 'Endurance road bike with IsoSpeed technology for maximum comfort. Perfect for long rides and rough roads.',
                'price' => 5499.99,
                'bike_type' => 'road',
                'frame_material' => 'carbon',
                'brake_type' => 'disc_brake_hydraulic',
                'wheel_size' => '700c',
                'weight' => 8.1,
                'weight_unit' => 'kg',
                'brand' => 'Trek',
                'model' => 'Domane SL 7',
                'year' => 2022,
                'status' => 'active',
                'category_slug' => 'road-bikes',
            ],
            [
                'title' => 'Cannondale SuperSix EVO',
                'description' => 'Lightweight carbon road bike with exceptional handling. Ideal for climbing and fast descents.',
                'price' => 6299.99,
                'bike_type' => 'road',
                'frame_material' => 'carbon',
                'brake_type' => 'disc_brake_hydraulic',
                'wheel_size' => '700c',
                'weight' => 7.5,
                'weight_unit' => 'kg',
                'brand' => 'Cannondale',
                'model' => 'SuperSix EVO',
                'year' => 2023,
                'status' => 'active',
                'category_slug' => 'road-bikes',
            ],
            // Mountain Bikes
            [
                'title' => 'Santa Cruz Hightower',
                'description' => 'Versatile trail bike with 140mm travel. Excellent for technical trails and all-mountain riding.',
                'price' => 5999.99,
                'bike_type' => 'mountain',
                'frame_material' => 'carbon',
                'brake_type' => 'disc_brake_hydraulic',
                'wheel_size' => '29',
                'weight' => 12.8,
                'weight_unit' => 'kg',
                'brand' => 'Santa Cruz',
                'model' => 'Hightower',
                'year' => 2023,
                'status' => 'active',
                'category_slug' => 'mountain-bikes',
            ],
            [
                'title' => 'Trek Fuel EX 9.8',
                'description' => 'Full-suspension mountain bike with 130mm travel. Perfect balance of climbing efficiency and descending capability.',
                'price' => 5499.99,
                'bike_type' => 'mountain',
                'frame_material' => 'carbon',
                'brake_type' => 'disc_brake_hydraulic',
                'wheel_size' => '29',
                'weight' => 13.2,
                'weight_unit' => 'kg',
                'brand' => 'Trek',
                'model' => 'Fuel EX 9.8',
                'year' => 2022,
                'status' => 'active',
                'category_slug' => 'mountain-bikes',
            ],
            [
                'title' => 'Specialized Stumpjumper EVO',
                'description' => 'Aggressive trail bike with adjustable geometry. Built for riders who want to push limits.',
                'price' => 6999.99,
                'bike_type' => 'mountain',
                'frame_material' => 'carbon',
                'brake_type' => 'disc_brake_hydraulic',
                'wheel_size' => '29',
                'weight' => 13.5,
                'weight_unit' => 'kg',
                'brand' => 'Specialized',
                'model' => 'Stumpjumper EVO',
                'year' => 2023,
                'status' => 'active',
                'category_slug' => 'mountain-bikes',
            ],
            // Electric Bikes
            [
                'title' => 'Trek Powerfly FS 9.7',
                'description' => 'Full-suspension e-MTB with Bosch motor. Conquer any trail with electric assistance.',
                'price' => 6499.99,
                'bike_type' => 'electric',
                'frame_material' => 'aluminum',
                'brake_type' => 'disc_brake_hydraulic',
                'wheel_size' => '29',
                'weight' => 23.5,
                'weight_unit' => 'kg',
                'brand' => 'Trek',
                'model' => 'Powerfly FS 9.7',
                'year' => 2023,
                'status' => 'active',
                'category_slug' => 'electric-bikes',
            ],
            [
                'title' => 'Specialized Turbo Levo SL',
                'description' => 'Lightweight e-MTB with Specialized SL motor. Natural riding feel with electric boost when needed.',
                'price' => 8999.99,
                'bike_type' => 'electric',
                'frame_material' => 'carbon',
                'brake_type' => 'disc_brake_hydraulic',
                'wheel_size' => '29',
                'weight' => 18.2,
                'weight_unit' => 'kg',
                'brand' => 'Specialized',
                'model' => 'Turbo Levo SL',
                'year' => 2023,
                'status' => 'active',
                'category_slug' => 'electric-bikes',
            ],
            // Gravel Bikes
            [
                'title' => 'Cannondale Topstone Carbon',
                'description' => 'Carbon gravel bike with Kingpin suspension. Smooth ride on any surface.',
                'price' => 4299.99,
                'bike_type' => 'gravel',
                'frame_material' => 'carbon',
                'brake_type' => 'disc_brake_hydraulic',
                'wheel_size' => '700c',
                'weight' => 8.9,
                'weight_unit' => 'kg',
                'brand' => 'Cannondale',
                'model' => 'Topstone Carbon',
                'year' => 2023,
                'status' => 'active',
                'category_slug' => 'gravel-bikes',
            ],
            [
                'title' => 'Trek Checkpoint SL 7',
                'description' => 'Adventure gravel bike with IsoSpeed. Ready for long-distance gravel events and bikepacking.',
                'price' => 4999.99,
                'bike_type' => 'gravel',
                'frame_material' => 'carbon',
                'brake_type' => 'disc_brake_hydraulic',
                'wheel_size' => '700c',
                'weight' => 9.1,
                'weight_unit' => 'kg',
                'brand' => 'Trek',
                'model' => 'Checkpoint SL 7',
                'year' => 2022,
                'status' => 'active',
                'category_slug' => 'gravel-bikes',
            ],
            // Hybrid Bikes
            [
                'title' => 'Trek FX 3 Disc',
                'description' => 'Comfortable hybrid bike perfect for commuting and fitness riding. Lightweight aluminum frame.',
                'price' => 899.99,
                'bike_type' => 'hybrid',
                'frame_material' => 'aluminum',
                'brake_type' => 'disc_brake_mechanical',
                'wheel_size' => '700c',
                'weight' => 11.5,
                'weight_unit' => 'kg',
                'brand' => 'Trek',
                'model' => 'FX 3 Disc',
                'year' => 2023,
                'status' => 'active',
                'category_slug' => 'hybrid-bikes',
            ],
            [
                'title' => 'Specialized Sirrus X 3.0',
                'description' => 'Versatile hybrid bike with wide tires. Great for urban riding and light trails.',
                'price' => 1099.99,
                'bike_type' => 'hybrid',
                'frame_material' => 'aluminum',
                'brake_type' => 'disc_brake_mechanical',
                'wheel_size' => '700c',
                'weight' => 11.8,
                'weight_unit' => 'kg',
                'brand' => 'Specialized',
                'model' => 'Sirrus X 3.0',
                'year' => 2023,
                'status' => 'active',
                'category_slug' => 'hybrid-bikes',
            ],
        ];

        foreach ($bikes as $index => $bikeData) {
            $category = $categories->firstWhere('slug', $bikeData['category_slug']);
            $seller = $sellers->random();
            
            unset($bikeData['category_slug']);
            
            $product = Product::create([
                ...$bikeData,
                'seller_id' => $seller->id,
                'category_id' => $category?->id,
            ]);

            // Create placeholder images (store URL reference)
            $imageUrls = [
                'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1571068316344-75bc76f77890?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1571066811602-716837d681de?w=800&h=600&fit=crop',
            ];

            foreach ($imageUrls as $order => $url) {
                // Store as placeholder path (you can download images later if needed)
                $filename = 'products/placeholder_' . $product->id . '_' . ($order + 1) . '.jpg';
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $filename, // Store placeholder path
                    'is_primary' => $order === 0,
                    'order' => $order,
                ]);
            }
        }

        // Create additional random products
        Product::factory()
            ->count(15)
            ->create([
                'status' => 'active',
            ])
            ->each(function ($product) use ($categories, $sellers) {
                $product->update([
                    'seller_id' => $sellers->random()->id,
                    'category_id' => $categories->random()->id,
                ]);

                // Add placeholder image
                $filename = 'products/placeholder_' . $product->id . '_1.jpg';
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $filename,
                    'is_primary' => true,
                    'order' => 0,
                ]);
            });
    }
}

