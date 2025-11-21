<?php

namespace App\Application\Payment\DTOs;

readonly class RefundPaymentDTO
{
    public function __construct(
        public int $paymentId,
        public ?float $amount = null, // If null, refund full amount
        public ?string $reason = null,
    ) {}
}

