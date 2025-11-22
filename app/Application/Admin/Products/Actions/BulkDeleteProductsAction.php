<?php

namespace App\Application\Admin\Products\Actions;

use App\Application\Admin\Common\DTOs\BulkActionDTO;

class BulkDeleteProductsAction
{
    public function execute(BulkActionDTO $dto): int
    {
        $deleted = 0;
        
        foreach ($dto->ids as $id) {
            try {
                \App\Models\Product::destroy($id);
                $deleted++;
            } catch (\Exception $e) {
                // Log error but continue
                \Log::error("Failed to delete product {$id}: " . $e->getMessage());
            }
        }

        return $deleted;
    }
}

