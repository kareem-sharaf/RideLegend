<?php

namespace App\Application\Admin\Products\Actions;

use App\Application\Admin\Products\DTOs\UpdateProductDTO;
use App\Application\Product\Actions\ChangeProductStatusAction;
use App\Application\Product\DTOs\UpdateProductDTO as ProductUpdateDTO;
use App\Domain\Product\Repositories\ProductRepositoryInterface;

class UpdateProductAction
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ChangeProductStatusAction $changeProductStatusAction,
    ) {}

    public function execute(UpdateProductDTO $dto): void
    {
        $product = $this->productRepository->findById($dto->productId);

        if (!$product) {
            throw new \DomainException('Product not found');
        }

        if ($dto->status) {
            $product->changeStatus($dto->status);
            $this->productRepository->save($product);
        }
    }
}

