<?php

namespace App\Application\Admin\Payments\Actions;

use App\Application\Admin\Payments\DTOs\ListPaymentsDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListPaymentsAction
{
    public function execute(ListPaymentsDTO $dto): LengthAwarePaginator
    {
        $query = \App\Models\Payment::with(['user', 'order']);

        if ($dto->status) {
            $query->where('status', $dto->status);
        }

        if ($dto->paymentMethod) {
            $query->where('payment_method', $dto->paymentMethod);
        }

        if ($dto->search) {
            $query->where(function($q) use ($dto) {
                $q->where('transaction_id', 'like', "%{$dto->search}%")
                  ->orWhereHas('user', function($q) use ($dto) {
                      $q->where('email', 'like', "%{$dto->search}%");
                  });
            });
        }

        if ($dto->userId) {
            $query->where('user_id', $dto->userId);
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

        if ($dto->minAmount !== null) {
            $query->where('amount', '>=', $dto->minAmount);
        }

        if ($dto->maxAmount !== null) {
            $query->where('amount', '<=', $dto->maxAmount);
        }

        return $query->orderBy($dto->sortBy, $dto->sortDirection)
            ->paginate($dto->perPage, ['*'], 'page', $dto->page);
    }
}

