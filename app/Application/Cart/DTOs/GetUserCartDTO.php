<?php

namespace App\Application\Cart\DTOs;

readonly class GetUserCartDTO
{
    public function __construct(
        public int $userId,
    ) {}
}

