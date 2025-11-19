<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'seller_id' => User::factory(),
            'title' => fake()->words(3, true) . ' Bike',
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 500, 10000),
            'bike_type' => fake()->randomElement(['road', 'mountain', 'gravel', 'hybrid', 'electric']),
            'frame_material' => fake()->randomElement(['carbon', 'aluminum', 'steel', 'titanium']),
            'brake_type' => fake()->randomElement(['rim_brake', 'disc_brake_mechanical', 'disc_brake_hydraulic']),
            'wheel_size' => fake()->randomElement(['26', '27.5', '29', '700c']),
            'weight' => fake()->randomFloat(2, 8, 15),
            'weight_unit' => 'kg',
            'brand' => fake()->company(),
            'model' => fake()->word(),
            'year' => fake()->numberBetween(2018, date('Y')),
            'status' => fake()->randomElement(['draft', 'pending', 'active']),
        ];
    }
}

