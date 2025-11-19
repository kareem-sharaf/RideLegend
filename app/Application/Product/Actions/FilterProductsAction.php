<?php

namespace App\Application\Product\Actions;

use App\Application\Product\DTOs\FilterProductsDTO;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Collection;

class FilterProductsAction
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function execute(FilterProductsDTO $dto): Collection
    {
        $criteria = [];

        if ($dto->categoryId) {
            $criteria['category_id'] = $dto->categoryId;
        }

        if ($dto->bikeType) {
            $criteria['bike_type'] = $dto->bikeType;
        }

        if ($dto->frameMaterial) {
            $criteria['frame_material'] = $dto->frameMaterial;
        }

        if ($dto->brakeType) {
            $criteria['brake_type'] = $dto->brakeType;
        }

        if ($dto->wheelSize) {
            $criteria['wheel_size'] = $dto->wheelSize;
        }

        if ($dto->minPrice !== null) {
            $criteria['min_price'] = $dto->minPrice;
        }

        if ($dto->maxPrice !== null) {
            $criteria['max_price'] = $dto->maxPrice;
        }

        if ($dto->certifiedOnly) {
            $criteria['certified_only'] = true;
        }

        if ($dto->status) {
            $criteria['status'] = $dto->status;
        }

        if ($dto->search) {
            $criteria['search'] = $dto->search;
        }

        return $this->productRepository->search($criteria);
    }
}

