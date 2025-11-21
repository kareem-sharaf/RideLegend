<?php

namespace App\Application\Order\DTOs;

readonly class UpdateOrderStatusDTO
{
    public function __construct(
        public int $orderId,
        public string $status,
    ) {}
}

