<?php

namespace App\Application\User\DTOs;

final class UpdateUserProfileDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?string $phone = null,
    ) {}

    public static function fromArray(int $userId, array $data): self
    {
        return new self(
            userId: $userId,
            firstName: $data['first_name'] ?? null,
            lastName: $data['last_name'] ?? null,
            phone: $data['phone'] ?? null,
        );
    }
}

