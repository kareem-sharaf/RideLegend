<?php

namespace App\Application\Product\Actions;

use App\Domain\Product\Models\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

class ChangeProductStatusAction
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function execute(int $productId, string $status): Product
    {
        $product = $this->productRepository->findById($productId);

        if ($product === null) {
            throw new BusinessRuleViolationException(
                'Product not found',
                'PRODUCT_NOT_FOUND'
            );
        }

        $product->changeStatus($status);

        return $this->productRepository->save($product);
    }
}

