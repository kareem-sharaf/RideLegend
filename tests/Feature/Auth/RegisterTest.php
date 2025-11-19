<?php

use App\Domain\User\Repositories\UserRepositoryInterface;

test('user can register', function () {
    $response = $this->postJson('/api/auth/register', [
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'role' => 'buyer',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'user' => [
                'id',
                'email',
                'role',
                'first_name',
                'last_name',
            ],
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'role' => 'buyer',
    ]);
});

test('registration requires valid email', function () {
    $response = $this->postJson('/api/auth/register', [
        'email' => 'invalid-email',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

test('registration requires password confirmation', function () {
    $response = $this->postJson('/api/auth/register', [
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'different',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
});

test('cannot register with duplicate email', function () {
    $user = \App\Models\User::factory()->create(['email' => 'existing@example.com']);

    $response = $this->postJson('/api/auth/register', [
        'email' => 'existing@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

