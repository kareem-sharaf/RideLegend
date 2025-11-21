<?php

namespace App\Application\Cart\DTOs;

readonly class UpdateCartQuantityDTO
{
    public function __construct(
        public int $userId,
        public int $cartItemId,
        public int $quantity,
    ) {}
}

