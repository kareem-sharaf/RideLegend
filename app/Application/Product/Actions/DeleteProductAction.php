<?php

namespace App\Application\Product\Actions;

use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

class DeleteProductAction
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function execute(int $productId, int $sellerId): void
    {
        $product = $this->productRepository->findById($productId);

        if ($product === null) {
            throw new BusinessRuleViolationException(
                'Product not found',
                'PRODUCT_NOT_FOUND'
            );
        }

        if ($product->getSellerId() !== $sellerId) {
            throw new BusinessRuleViolationException(
                'You do not have permission to delete this product',
                'UNAUTHORIZED'
            );
        }

        $this->productRepository->delete($product);
    }
}

