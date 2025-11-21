<?php

namespace App\Application\Cart\DTOs;

readonly class RemoveFromCartDTO
{
    public function __construct(
        public int $userId,
        public int $cartItemId,
    ) {}
}

