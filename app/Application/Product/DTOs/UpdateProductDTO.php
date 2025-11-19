<?php

namespace App\Application\Product\DTOs;

final class UpdateProductDTO
{
    public function __construct(
        public readonly int $productId,
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        public readonly ?float $price = null,
        public readonly ?string $bikeType = null,
        public readonly ?string $frameMaterial = null,
        public readonly ?string $brakeType = null,
        public readonly ?string $wheelSize = null,
        public readonly ?float $weight = null,
        public readonly ?string $weightUnit = 'kg',
        public readonly ?string $brand = null,
        public readonly ?string $model = null,
        public readonly ?int $year = null,
        public readonly ?int $categoryId = null,
    ) {}

    public static function fromArray(int $productId, array $data): self
    {
        return new self(
            productId: $productId,
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            price: $data['price'] ?? null,
            bikeType: $data['bike_type'] ?? $data['bikeType'] ?? null,
            frameMaterial: $data['frame_material'] ?? $data['frameMaterial'] ?? null,
            brakeType: $data['brake_type'] ?? $data['brakeType'] ?? null,
            wheelSize: $data['wheel_size'] ?? $data['wheelSize'] ?? null,
            weight: $data['weight'] ?? null,
            weightUnit: $data['weight_unit'] ?? $data['weightUnit'] ?? 'kg',
            brand: $data['brand'] ?? null,
            model: $data['model'] ?? null,
            year: $data['year'] ?? null,
            categoryId: $data['category_id'] ?? $data['categoryId'] ?? null,
        );
    }
}

