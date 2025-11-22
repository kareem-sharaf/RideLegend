<?php

namespace App\Application\Admin\Orders\DTOs;

readonly class CancelOrderDTO
{
    public function __construct(
        public int $orderId,
    ) {}
}

