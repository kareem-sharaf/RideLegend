<?php

namespace App\Application\Auth\DTOs;

final class RegisterUserDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $passwordConfirmation,
        public readonly string $role = 'buyer',
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?string $phone = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
            passwordConfirmation: $data['password_confirmation'] ?? $data['password'],
            role: $data['role'] ?? 'buyer',
            firstName: $data['first_name'] ?? null,
            lastName: $data['last_name'] ?? null,
            phone: $data['phone'] ?? null,
        );
    }
}

