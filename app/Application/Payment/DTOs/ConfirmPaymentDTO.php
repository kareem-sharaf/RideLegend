<?php

namespace App\Application\Payment\DTOs;

readonly class ConfirmPaymentDTO
{
    public function __construct(
        public int $paymentId,
        public string $transactionId,
        public ?array $gatewayResponse = null,
    ) {}
}

