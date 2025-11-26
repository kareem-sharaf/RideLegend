<?php

namespace App\Application\Product\DTOs;

final class FilterProductsDTO
{
    public function __construct(
        public readonly ?int $categoryId = null,
        public readonly mixed $bikeType = null,
        public readonly mixed $frameMaterial = null,
        public readonly ?string $brakeType = null,
        public readonly ?string $wheelSize = null,
        public readonly ?float $minPrice = null,
        public readonly ?float $maxPrice = null,
        public readonly ?float $minWeight = null,
        public readonly ?float $maxWeight = null,
        public readonly ?bool $certifiedOnly = false,
        public readonly ?string $status = null,
        public readonly ?string $search = null,
        public readonly ?string $sortBy = null,
        public readonly ?string $sortDirection = null,
        public readonly int $page = 1,
        public readonly int $perPage = 24,
    ) {}

    public static function fromArray(array $data): self
    {
        // Handle bike_type as array (from checkboxes)
        $bikeType = $data['bike_type'] ?? $data['bikeType'] ?? null;
        if (is_array($bikeType) && !empty($bikeType)) {
            $bikeType = $bikeType;
        } elseif (is_string($bikeType) && empty($bikeType)) {
            $bikeType = null;
        }

        // Handle frame_material as array (from checkboxes)
        $frameMaterial = $data['frame_material'] ?? $data['frameMaterial'] ?? null;
        if (is_array($frameMaterial) && !empty($frameMaterial)) {
            $frameMaterial = $frameMaterial;
        } elseif (is_string($frameMaterial) && empty($frameMaterial)) {
            $frameMaterial = null;
        }

        return new self(
            categoryId: $data['category_id'] ?? $data['categoryId'] ?? null,
            bikeType: $bikeType,
            frameMaterial: $frameMaterial,
            brakeType: $data['brake_type'] ?? $data['brakeType'] ?? null,
            wheelSize: $data['wheel_size'] ?? $data['wheelSize'] ?? null,
            minPrice: isset($data['min_price']) ? (float) $data['min_price'] : ($data['minPrice'] ?? null),
            maxPrice: isset($data['max_price']) ? (float) $data['max_price'] : ($data['maxPrice'] ?? null),
            minWeight: isset($data['min_weight']) ? (float) $data['min_weight'] : ($data['minWeight'] ?? null),
            maxWeight: isset($data['max_weight']) ? (float) $data['max_weight'] : ($data['maxWeight'] ?? null),
            certifiedOnly: $data['certified_only'] ?? $data['certifiedOnly'] ?? false,
            status: $data['status'] ?? null,
            search: $data['search'] ?? null,
            sortBy: $data['sort'] ?? $data['sortBy'] ?? null,
            sortDirection: $data['sort_direction'] ?? $data['sortDirection'] ?? null,
            page: $data['page'] ?? 1,
            perPage: $data['per_page'] ?? $data['perPage'] ?? 24,
        );
    }
}
