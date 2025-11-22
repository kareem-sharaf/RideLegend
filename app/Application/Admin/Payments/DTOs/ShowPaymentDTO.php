<?php

namespace App\Application\Admin\Payments\DTOs;

readonly class ShowPaymentDTO
{
    public function __construct(
        public int $paymentId,
    ) {}
}

