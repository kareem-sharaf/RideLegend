<?php

namespace App\Application\Checkout\DTOs;

readonly class CalculateCartTotalsDTO
{
    public function __construct(
        public int $userId,
        public ?float $shippingCost = null,
        public ?float $discount = null,
        public float $taxRate = 0.0,
    ) {}
}

