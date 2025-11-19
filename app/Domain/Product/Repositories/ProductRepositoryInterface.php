<?php

namespace App\Domain\Product\Repositories;

use App\Domain\Product\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function save(Product $product): Product;

    public function findById(int $id): ?Product;

    public function findBySellerId(int $sellerId): Collection;

    public function findByCategoryId(int $categoryId): Collection;

    public function findByStatus(string $status): Collection;

    public function search(array $criteria): Collection;

    public function delete(Product $product): void;
}

