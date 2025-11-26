<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::firstOrCreate(
            ['email' => 'admin@ridelegend.com'],
            [
                'password' => Hash::make('password'),
                'role' => 'admin',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'phone' => '+1234567890',
                'email_verified_at' => now(),
            ]
        );

        // Create Sellers
        $sellers = [
            [
                'email' => 'john.seller@example.com',
                'first_name' => 'John',
                'last_name' => 'Smith',
                'phone' => '+1234567891',
            ],
            [
                'email' => 'sarah.seller@example.com',
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'phone' => '+1234567892',
            ],
            [
                'email' => 'mike.seller@example.com',
                'first_name' => 'Michael',
                'last_name' => 'Chen',
                'phone' => '+1234567893',
            ],
            [
                'email' => 'emily.seller@example.com',
                'first_name' => 'Emily',
                'last_name' => 'Rodriguez',
                'phone' => '+1234567894',
            ],
        ];

        foreach ($sellers as $seller) {
            User::firstOrCreate(
                ['email' => $seller['email']],
                [
                    ...$seller,
                    'password' => Hash::make('password'),
                    'role' => 'seller',
                    'email_verified_at' => now(),
                ]
            );
        }

        // Create Buyers
        User::factory()->count(10)->create([
            'role' => 'buyer',
            'email_verified_at' => now(),
        ]);
    }
}

