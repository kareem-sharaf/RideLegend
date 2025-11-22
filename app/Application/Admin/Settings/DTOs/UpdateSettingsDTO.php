<?php

namespace App\Application\Admin\Settings\DTOs;

readonly class UpdateSettingsDTO
{
    public function __construct(
        public ?float $commissionRate = null,
        public ?float $sellerCommissionRate = null,
        public ?float $platformFee = null,
        public ?float $inspectionFee = null,
        public ?float $shippingBaseCost = null,
    ) {}
}

