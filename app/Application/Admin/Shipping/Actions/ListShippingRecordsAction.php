<?php

namespace App\Application\Admin\Shipping\Actions;

use App\Application\Admin\Shipping\DTOs\ListShippingRecordsDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListShippingRecordsAction
{
    public function execute(ListShippingRecordsDTO $dto): LengthAwarePaginator
    {
        $query = \App\Models\Shipping::with(['order']);

        if ($dto->status) {
            $query->where('status', $dto->status);
        }

        if ($dto->carrier) {
            $query->where('carrier', $dto->carrier);
        }

        if ($dto->search) {
            $query->where(function($q) use ($dto) {
                $q->where('tracking_number', 'like', "%{$dto->search}%")
                  ->orWhereHas('order', function($q) use ($dto) {
                      $q->where('order_number', 'like', "%{$dto->search}%");
                  });
            });
        }

        if ($dto->orderId) {
            $query->where('order_id', $dto->orderId);
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

