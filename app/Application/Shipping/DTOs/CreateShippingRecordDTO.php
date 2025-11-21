<?php

namespace App\Application\Shipping\DTOs;

readonly class CreateShippingRecordDTO
{
    public function __construct(
        public int $orderId,
        public string $carrier,
        public string $serviceType,
        public float $cost,
        public string $currency = 'USD',
    ) {}
}

