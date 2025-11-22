<?php

namespace App\Application\Admin\Payments\DTOs;

readonly class RefundPaymentDTO
{
    public function __construct(
        public int $paymentId,
        public ?float $amount = null,
        public ?string $reason = null,
    ) {}
}

