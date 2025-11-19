<?php

test('user can login with valid credentials', function () {
    $user = \App\Models\User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->postJson('/api/auth/login', [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'user',
        ]);

    $this->assertAuthenticated();
});

test('user cannot login with invalid credentials', function () {
    $user = \App\Models\User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->postJson('/api/auth/login', [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(422);
    $this->assertGuest();
});

test('user can logout', function () {
    $user = \App\Models\User::factory()->create();
    
    $this->actingAs($user);

    $response = $this->postJson('/api/auth/logout');

    $response->assertStatus(200)
        ->assertJson(['message' => 'Logged out successfully']);

    $this->assertGuest();
});

