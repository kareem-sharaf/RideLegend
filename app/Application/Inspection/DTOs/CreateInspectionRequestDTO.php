<?php

namespace App\Application\Inspection\DTOs;

final class CreateInspectionRequestDTO
{
    public function __construct(
        public readonly int $productId,
        public readonly int $sellerId,
        public readonly int $workshopId,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            productId: $data['product_id'] ?? $data['productId'],
            sellerId: $data['seller_id'] ?? $data['sellerId'],
            workshopId: $data['workshop_id'] ?? $data['workshopId'],
        );
    }
}

