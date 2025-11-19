<?php

namespace App\Application\Product\DTOs;

final class CreateProductDTO
{
    public function __construct(
        public readonly int $sellerId,
        public readonly string $title,
        public readonly string $description,
        public readonly float $price,
        public readonly string $bikeType,
        public readonly string $frameMaterial,
        public readonly string $brakeType,
        public readonly string $wheelSize,
        public readonly ?float $weight = null,
        public readonly ?string $weightUnit = 'kg',
        public readonly string $brand = '',
        public readonly string $model = '',
        public readonly ?int $year = null,
        public readonly ?int $categoryId = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            sellerId: $data['seller_id'] ?? $data['sellerId'],
            title: $data['title'],
            description: $data['description'],
            price: $data['price'],
            bikeType: $data['bike_type'] ?? $data['bikeType'],
            frameMaterial: $data['frame_material'] ?? $data['frameMaterial'],
            brakeType: $data['brake_type'] ?? $data['brakeType'],
            wheelSize: $data['wheel_size'] ?? $data['wheelSize'],
            weight: $data['weight'] ?? null,
            weightUnit: $data['weight_unit'] ?? $data['weightUnit'] ?? 'kg',
            brand: $data['brand'] ?? '',
            model: $data['model'] ?? '',
            year: $data['year'] ?? null,
            categoryId: $data['category_id'] ?? $data['categoryId'] ?? null,
        );
    }
}

