<?php

namespace App\Application\Admin\Shipping\DTOs;

readonly class ShowShippingRecordDTO
{
    public function __construct(
        public int $shippingId,
    ) {}
}

