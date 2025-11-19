<?php

namespace App\Application\Product\Actions;

use App\Application\Product\DTOs\UpdateProductDTO;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\BikeType;
use App\Domain\Product\ValueObjects\BrakeType;
use App\Domain\Product\ValueObjects\FrameMaterial;
use App\Domain\Product\ValueObjects\Price;
use App\Domain\Product\ValueObjects\Title;
use App\Domain\Product\ValueObjects\Weight;
use App\Domain\Product\ValueObjects\WheelSize;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

class UpdateProductAction
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function execute(UpdateProductDTO $dto): Product
    {
        $product = $this->productRepository->findById($dto->productId);

        if ($product === null) {
            throw new BusinessRuleViolationException(
                'Product not found',
                'PRODUCT_NOT_FOUND'
            );
        }

        $title = $dto->title ? Title::fromString($dto->title) : null;
        $price = $dto->price ? Price::fromAmount($dto->price) : null;
        $bikeType = $dto->bikeType ? BikeType::fromString($dto->bikeType) : null;
        $frameMaterial = $dto->frameMaterial ? FrameMaterial::fromString($dto->frameMaterial) : null;
        $brakeType = $dto->brakeType ? BrakeType::fromString($dto->brakeType) : null;
        $wheelSize = $dto->wheelSize ? WheelSize::fromString($dto->wheelSize) : null;
        $weight = $dto->weight ? Weight::fromValue($dto->weight, $dto->weightUnit) : null;

        $product->update(
            title: $title,
            description: $dto->description,
            price: $price,
            bikeType: $bikeType,
            frameMaterial: $frameMaterial,
            brakeType: $brakeType,
            wheelSize: $wheelSize,
            weight: $weight,
            brand: $dto->brand,
            model: $dto->model,
            year: $dto->year,
            categoryId: $dto->categoryId
        );

        return $this->productRepository->save($product);
    }
}

