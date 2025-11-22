<?php

namespace App\Application\Admin\Products\DTOs;

readonly class ShowProductDTO
{
    public function __construct(
        public int $productId,
    ) {}
}

