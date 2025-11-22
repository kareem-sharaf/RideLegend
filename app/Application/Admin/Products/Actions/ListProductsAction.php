<?php

namespace App\Application\Admin\Products\Actions;

use App\Application\Admin\Products\DTOs\ListProductsDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListProductsAction
{
    public function execute(ListProductsDTO $dto): LengthAwarePaginator
    {
        $query = \App\Models\Product::with(['seller', 'category', 'certification']);

        if ($dto->status) {
            $query->where('status', $dto->status);
        }

        if ($dto->search) {
            $query->where(function($q) use ($dto) {
                $q->where('title', 'like', "%{$dto->search}%")
                  ->orWhere('brand', 'like', "%{$dto->search}%")
                  ->orWhere('model', 'like', "%{$dto->search}%");
            });
        }

        if ($dto->sellerId) {
            $query->where('seller_id', $dto->sellerId);
        }

        if ($dto->categoryId) {
            $query->where('category_id', $dto->categoryId);
        }

        if ($dto->minPrice !== null) {
            $query->where('price', '>=', $dto->minPrice);
        }

        if ($dto->maxPrice !== null) {
            $query->where('price', '<=', $dto->maxPrice);
        }

        if ($dto->dateFrom) {
            $query->whereDate('created_at', '>=', $dto->dateFrom);
        }

        if ($dto->dateTo) {
            $query->whereDate('created_at', '<=', $dto->dateTo);
        }

        return $query->orderBy($dto->sortBy, $dto->sortDirection)
            ->paginate($dto->perPage, ['*'], 'page', $dto->page);
    }
}

