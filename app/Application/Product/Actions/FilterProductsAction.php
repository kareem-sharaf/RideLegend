<?php

namespace App\Application\Product\Actions;

use App\Application\Product\DTOs\FilterProductsDTO;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FilterProductsAction
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function execute(FilterProductsDTO $dto): LengthAwarePaginator
    {
        $query = Product::with(['images', 'category', 'seller'])
            ->where('status', 'active');

        // Category filter
        if ($dto->categoryId) {
            $query->where('category_id', $dto->categoryId);
        }

        // Bike type filter (can be array or string)
        if ($dto->bikeType) {
            if (is_array($dto->bikeType)) {
                $query->whereIn('bike_type', $dto->bikeType);
            } else {
                $query->where('bike_type', $dto->bikeType);
            }
        }

        // Frame material filter (can be array or string)
        if ($dto->frameMaterial) {
            if (is_array($dto->frameMaterial)) {
                $query->whereIn('frame_material', $dto->frameMaterial);
            } else {
                $query->where('frame_material', $dto->frameMaterial);
            }
        }

        // Brake type filter
        if ($dto->brakeType) {
            $query->where('brake_type', $dto->brakeType);
        }

        // Wheel size filter
        if ($dto->wheelSize) {
            $query->where('wheel_size', $dto->wheelSize);
        }

        // Price range filters
        if ($dto->minPrice !== null) {
            $query->where('price', '>=', $dto->minPrice);
        }

        if ($dto->maxPrice !== null) {
            $query->where('price', '<=', $dto->maxPrice);
        }

        // Certified only filter
        if ($dto->certifiedOnly) {
            $query->whereNotNull('certification_id');
        }

        // Status filter (default is active, but allow override)
        if ($dto->status) {
            $query->where('status', $dto->status);
        }

        // Search filter
        if ($dto->search) {
            $search = $dto->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $dto->sortBy ?? 'created_at';
        $sortDirection = $dto->sortDirection ?? 'desc';

        switch ($sortBy) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->orderBy($sortBy, $sortDirection);
        }

        // Pagination
        $paginator = $query->paginate($dto->perPage, ['*'], 'page', $dto->page)
            ->withQueryString(); // Preserve query parameters

        // Convert Eloquent Models to Domain Models
        $repository = app(\App\Infrastructure\Repositories\Product\EloquentProductRepository::class);
        $paginator->getCollection()->transform(function ($eloquentProduct) use ($repository) {
            return $repository->toDomainModel($eloquentProduct);
        });

        return $paginator;
    }
}
