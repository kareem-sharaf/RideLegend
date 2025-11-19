<?php

use App\Domain\User\Events\UserRegistered;
use App\Domain\User\Models\User;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\PhoneNumber;

test('user can be created', function () {
    $email = Email::fromString('test@example.com');
    $phone = PhoneNumber::fromString('+1234567890');
    
    $user = User::create(
        email: $email,
        password: 'password123',
        role: 'buyer',
        firstName: 'John',
        lastName: 'Doe',
        phone: $phone
    );

    expect($user->getEmail()->toString())->toBe('test@example.com')
        ->and($user->getFirstName())->toBe('John')
        ->and($user->getLastName())->toBe('Doe')
        ->and($user->getRole())->toBe('buyer')
        ->and($user->getPhone()->toString())->toBe('+1234567890');
});

test('user creation dispatches UserRegistered event', function () {
    $email = Email::fromString('test@example.com');
    
    $user = User::create(
        email: $email,
        password: 'password123'
    );

    $events = $user->getDomainEvents();
    
    expect($events)->toHaveCount(1)
        ->and($events->first())->toBeInstanceOf(UserRegistered::class);
});

test('user can update profile', function () {
    $email = Email::fromString('test@example.com');
    $user = User::create($email, 'password123');
    
    $newPhone = PhoneNumber::fromString('+9876543210');
    $user->updateProfile(
        firstName: 'Jane',
        lastName: 'Smith',
        phone: $newPhone
    );

    expect($user->getFirstName())->toBe('Jane')
        ->and($user->getLastName())->toBe('Smith')
        ->and($user->getPhone()->toString())->toBe('+9876543210');
});

test('user can change password', function () {
    $email = Email::fromString('test@example.com');
    $user = User::create($email, 'oldpassword');
    
    $user->changePassword('newpassword');

    expect($user->getPassword())->toBe('newpassword');
});

test('user can assign role', function () {
    $email = Email::fromString('test@example.com');
    $user = User::create($email, 'password123', 'buyer');
    
    $user->assignRole('seller');

    expect($user->getRole())->toBe('seller')
        ->and($user->hasRole('seller'))->toBeTrue();
});

