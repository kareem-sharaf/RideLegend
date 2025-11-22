<?php

namespace App\Application\Admin\Orders\DTOs;

readonly class ShowOrderDTO
{
    public function __construct(
        public int $orderId,
    ) {}
}

