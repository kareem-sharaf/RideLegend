<?php

namespace App\Application\Admin\Users\DTOs;

readonly class BanUserDTO
{
    public function __construct(
        public int $userId,
        public ?string $reason = null,
    ) {}
}

