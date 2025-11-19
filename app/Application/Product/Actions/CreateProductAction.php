<?php

namespace App\Application\Product\Actions;

use App\Application\Product\DTOs\CreateProductDTO;
use App\Domain\Product\Events\ProductCreated;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\BikeType;
use App\Domain\Product\ValueObjects\BrakeType;
use App\Domain\Product\ValueObjects\FrameMaterial;
use App\Domain\Product\ValueObjects\Price;
use App\Domain\Product\ValueObjects\Title;
use App\Domain\Product\ValueObjects\Weight;
use App\Domain\Product\ValueObjects\WheelSize;
use Illuminate\Contracts\Events\Dispatcher;

class CreateProductAction
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private Dispatcher $eventDispatcher
    ) {}

    public function execute(CreateProductDTO $dto): Product
    {
        $title = Title::fromString($dto->title);
        $price = Price::fromAmount($dto->price);
        $bikeType = BikeType::fromString($dto->bikeType);
        $frameMaterial = FrameMaterial::fromString($dto->frameMaterial);
        $brakeType = BrakeType::fromString($dto->brakeType);
        $wheelSize = WheelSize::fromString($dto->wheelSize);
        $weight = $dto->weight ? Weight::fromValue($dto->weight, $dto->weightUnit) : null;

        $product = Product::create(
            sellerId: $dto->sellerId,
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

        $product = $this->productRepository->save($product);

        // Dispatch domain events
        $product->getDomainEvents()->each(function ($event) {
            $this->eventDispatcher->dispatch($event);
        });
        $product->clearDomainEvents();

        return $product;
    }
}

