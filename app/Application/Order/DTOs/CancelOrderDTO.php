<?php

namespace App\Application\Order\DTOs;

readonly class CancelOrderDTO
{
    public function __construct(
        public int $orderId,
        public int $userId,
    ) {}
}

