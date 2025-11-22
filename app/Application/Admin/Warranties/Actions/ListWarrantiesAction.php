<?php

namespace App\Application\Admin\Warranties\Actions;

use App\Application\Admin\Warranties\DTOs\ListWarrantiesDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListWarrantiesAction
{
    public function execute(ListWarrantiesDTO $dto): LengthAwarePaginator
    {
        $query = \App\Models\Warranty::with(['order', 'product']);

        if ($dto->status) {
            $query->where('status', $dto->status);
        }

        if ($dto->type) {
            $query->where('type', $dto->type);
        }

        if ($dto->orderId) {
            $query->where('order_id', $dto->orderId);
        }

        if ($dto->productId) {
            $query->where('product_id', $dto->productId);
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

