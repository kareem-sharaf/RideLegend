<?php

namespace App\Application\Admin\Products\Actions;

use App\Application\Admin\Products\DTOs\DeleteProductDTO;
use App\Application\Product\Actions\DeleteProductAction as ProductDeleteAction;
use App\Application\Product\DTOs\UpdateProductDTO;

class DeleteProductAction
{
    public function __construct(
        private ProductDeleteAction $productDeleteAction,
    ) {}

    public function execute(DeleteProductDTO $dto): void
    {
        // Use existing delete product action
        $deleteDTO = new \App\Application\Product\DTOs\UpdateProductDTO(
            productId: $dto->productId,
            sellerId: 0, // Admin override
        );

        // We'll need to create a proper delete DTO
        // For now, delete directly
        \App\Models\Product::destroy($dto->productId);
    }
}

