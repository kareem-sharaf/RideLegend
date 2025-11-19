<?php

namespace Database\Factories;

use App\Models\Inspection;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inspection>
 */
class InspectionFactory extends Factory
{
    protected $model = Inspection::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'seller_id' => User::factory(),
            'workshop_id' => User::factory(),
            'status' => fake()->randomElement(['pending', 'scheduled', 'in_progress', 'completed']),
            'frame_grade' => fake()->randomElement(['excellent', 'very_good', 'good', 'fair', 'poor']),
            'brake_grade' => fake()->randomElement(['excellent', 'very_good', 'good', 'fair', 'poor']),
            'groupset_grade' => fake()->randomElement(['excellent', 'very_good', 'good', 'fair', 'poor']),
            'wheels_grade' => fake()->randomElement(['excellent', 'very_good', 'good', 'fair', 'poor']),
            'overall_grade' => fake()->randomElement(['A+', 'A', 'B', 'C']),
            'requested_at' => now(),
        ];
    }
}

