<?php

namespace App\Application\Admin\Inspections\Actions;

use App\Application\Admin\Inspections\DTOs\ListInspectionsDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListInspectionsAction
{
    public function execute(ListInspectionsDTO $dto): LengthAwarePaginator
    {
        $query = \App\Models\Inspection::with(['product', 'workshop']);

        if ($dto->status) {
            $query->where('status', $dto->status);
        }

        if ($dto->search) {
            $query->whereHas('product', function($q) use ($dto) {
                $q->where('title', 'like', "%{$dto->search}%");
            });
        }

        if ($dto->workshopId) {
            $query->where('workshop_id', $dto->workshopId);
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

