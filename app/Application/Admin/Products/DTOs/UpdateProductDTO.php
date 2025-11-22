<?php

namespace App\Application\Admin\Products\DTOs;

readonly class UpdateProductDTO
{
    public function __construct(
        public int $productId,
        public ?string $status = null,
        public ?string $rejectionReason = null,
    ) {}
}

