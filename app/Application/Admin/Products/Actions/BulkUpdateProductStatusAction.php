<?php

namespace App\Application\Admin\Products\Actions;

use App\Application\Admin\Common\DTOs\BulkActionDTO;

class BulkUpdateProductStatusAction
{
    public function execute(BulkActionDTO $dto): int
    {
        if (!isset($dto->data['status'])) {
            throw new \InvalidArgumentException('Status is required for bulk update');
        }

        $updated = \App\Models\Product::whereIn('id', $dto->ids)
            ->update(['status' => $dto->data['status']]);

        return $updated;
    }
}

