<?php

namespace App\Application\Admin\Shipping\DTOs;

readonly class UpdateShippingStatusDTO
{
    public function __construct(
        public int $shippingId,
        public string $status,
        public ?string $trackingNumber = null,
    ) {}
}

