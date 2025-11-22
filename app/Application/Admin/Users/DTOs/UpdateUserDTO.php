<?php

namespace App\Application\Admin\Users\DTOs;

readonly class UpdateUserDTO
{
    public function __construct(
        public int $userId,
        public string $firstName,
        public string $lastName,
        public string $email,
        public ?string $phone = null,
        public ?array $roles = null,
    ) {}
}

