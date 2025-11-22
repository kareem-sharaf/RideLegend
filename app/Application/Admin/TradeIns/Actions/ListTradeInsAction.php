<?php

namespace App\Application\Admin\TradeIns\Actions;

use App\Application\Admin\TradeIns\DTOs\ListTradeInsDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListTradeInsAction
{
    public function execute(ListTradeInsDTO $dto): LengthAwarePaginator
    {
        $query = \App\Models\TradeIn::with(['buyer', 'request', 'valuation']);

        if ($dto->status) {
            $query->where('status', $dto->status);
        }

        if ($dto->search) {
            $query->whereHas('buyer', function($q) use ($dto) {
                $q->where('email', 'like', "%{$dto->search}%")
                  ->orWhere('first_name', 'like', "%{$dto->search}%")
                  ->orWhere('last_name', 'like', "%{$dto->search}%");
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

        return $query->orderBy($dto->sortBy, $dto->sortDirection)
            ->paginate($dto->perPage, ['*'], 'page', $dto->page);
    }
}

