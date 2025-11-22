<?php

namespace App\Application\Admin\Orders\DTOs;

readonly class UpdateOrderStatusDTO
{
    public function __construct(
        public int $orderId,
        public string $status,
    ) {}
}

