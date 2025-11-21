<?php

namespace App\Application\Payment\DTOs;

readonly class ProcessPaymentDTO
{
    public function __construct(
        public int $orderId,
        public int $userId,
        public string $paymentMethod,
        public float $amount,
        public string $currency = 'USD',
        public ?array $paymentData = null,
    ) {}
}

