<?php

namespace App\Application\Admin\Products\Actions;

use App\Application\Admin\Products\DTOs\ShowProductDTO;
use App\Domain\Product\Repositories\ProductRepositoryInterface;

class ShowProductAction
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function execute(ShowProductDTO $dto)
    {
        $product = $this->productRepository->findById($dto->productId);

        if (!$product) {
            throw new \DomainException('Product not found');
        }

        return $product;
    }
}

