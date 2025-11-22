<?php

namespace App\Application\Admin\Warranties\DTOs;

readonly class UpdateWarrantyDTO
{
    public function __construct(
        public int $warrantyId,
        public ?string $status = null,
    ) {}
}

