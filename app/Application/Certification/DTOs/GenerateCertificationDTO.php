<?php

namespace App\Application\Certification\DTOs;

final class GenerateCertificationDTO
{
    public function __construct(
        public readonly int $productId,
        public readonly int $inspectionId,
        public readonly int $workshopId,
        public readonly string $grade,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            productId: $data['product_id'] ?? $data['productId'],
            inspectionId: $data['inspection_id'] ?? $data['inspectionId'],
            workshopId: $data['workshop_id'] ?? $data['workshopId'],
            grade: $data['grade'],
        );
    }
}

