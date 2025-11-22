<?php

namespace App\Application\Admin\Warranties\DTOs;

readonly class ShowWarrantyDTO
{
    public function __construct(
        public int $warrantyId,
    ) {}
}

