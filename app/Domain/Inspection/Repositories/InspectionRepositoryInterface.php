<?php

namespace App\Domain\Inspection\Repositories;

use App\Domain\Inspection\Models\Inspection;
use Illuminate\Support\Collection;

interface InspectionRepositoryInterface
{
    public function save(Inspection $inspection): Inspection;

    public function findById(int $id): ?Inspection;

    public function findByProductId(int $productId): ?Inspection;

    public function findByWorkshopId(int $workshopId): Collection;

    public function findByStatus(string $status): Collection;

    public function delete(Inspection $inspection): void;
}

