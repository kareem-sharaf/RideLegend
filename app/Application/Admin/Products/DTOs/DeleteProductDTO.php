<?php

namespace App\Application\Admin\Products\DTOs;

readonly class DeleteProductDTO
{
    public function __construct(
        public int $productId,
    ) {}
}

