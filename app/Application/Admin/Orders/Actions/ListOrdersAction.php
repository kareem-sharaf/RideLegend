<?php

namespace App\Application\Admin\Orders\Actions;

use App\Application\Admin\Orders\DTOs\ListOrdersDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListOrdersAction
{
    public function execute(ListOrdersDTO $dto): LengthAwarePaginator
    {
        $query = \App\Models\Order::with(['buyer', 'items.product']);

        if ($dto->status) {
            $query->where('status', $dto->status);
        }

        if ($dto->search) {
            $query->where(function($q) use ($dto) {
                $q->where('order_number', 'like', "%{$dto->search}%")
                  ->orWhereHas('buyer', function($q) use ($dto) {
                      $q->where('first_name', 'like', "%{$dto->search}%")
                        ->orWhere('last_name', 'like', "%{$dto->search}%")
                        ->orWhere('email', 'like', "%{$dto->search}%");
                  });
            });
        }

        if ($dto->buyerId) {
            $query->where('buyer_id', $dto->buyerId);
        }

        if ($dto->dateFrom) {
            $query->whereDate('created_at', '>=', $dto->dateFrom);
        }

        if ($dto->dateTo) {
            $query->whereDate('created_at', '<=', $dto->dateTo);
        }

        if ($dto->minTotal !== null) {
            $query->where('total', '>=', $dto->minTotal);
        }

        if ($dto->maxTotal !== null) {
            $query->where('total', '<=', $dto->maxTotal);
        }

        return $query->orderBy($dto->sortBy, $dto->sortDirection)
            ->paginate($dto->perPage, ['*'], 'page', $dto->page);
    }
}

