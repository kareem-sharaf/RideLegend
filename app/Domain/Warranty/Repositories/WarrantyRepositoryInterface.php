<?php

namespace App\Domain\Warranty\Repositories;

use App\Domain\Warranty\Models\Warranty;

interface WarrantyRepositoryInterface
{
    public function save(Warranty $warranty): void;

    public function findById(int $id): ?Warranty;

    public function findByOrderId(int $orderId): array;

    public function findByProductId(int $productId): array;
}

