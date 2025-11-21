<?php

namespace App\Application\Cart\DTOs;

readonly class AddToCartDTO
{
    public function __construct(
        public int $userId,
        public int $productId,
        public int $quantity,
    ) {}
}

