<?php

namespace App\Infrastructure\Repositories\Warranty;

use App\Domain\Warranty\Models\Warranty;
use App\Domain\Warranty\Repositories\WarrantyRepositoryInterface;
use App\Models\Warranty as EloquentWarranty;

class EloquentWarrantyRepository implements WarrantyRepositoryInterface
{
    public function save(Warranty $warranty): void
    {
        $eloquent = EloquentWarranty::updateOrCreate(
            ['id' => $warranty->getId()],
            [
                'order_id' => $warranty->getOrderId(),
                'product_id' => $warranty->getProductId(),
                'type' => $warranty->getType(),
                'price' => $warranty->getPrice(),
                'duration_months' => $warranty->getDurationMonths(),
                'starts_at' => $warranty->getStartsAt(),
                'expires_at' => $warranty->getExpiresAt(),
            ]
        );

        // Update warranty ID in domain model if it was new
        if (!$warranty->getId()) {
            $reflection = new \ReflectionClass($warranty);
            $idProperty = $reflection->getProperty('id');
            $idProperty->setAccessible(true);
            $idProperty->setValue($warranty, $eloquent->id);
        }
    }

    public function findById(int $id): ?Warranty
    {
        $eloquent = EloquentWarranty::find($id);

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findByOrderId(int $orderId): array
    {
        $eloquents = EloquentWarranty::where('order_id', $orderId)->get();

        return $eloquents->map(fn($eloquent) => $this->toDomain($eloquent))->toArray();
    }

    public function findByProductId(int $productId): array
    {
        $eloquents = EloquentWarranty::where('product_id', $productId)->get();

        return $eloquents->map(fn($eloquent) => $this->toDomain($eloquent))->toArray();
    }

    private function toDomain(EloquentWarranty $eloquent): Warranty
    {
        return new Warranty(
            id: $eloquent->id,
            orderId: $eloquent->order_id,
            productId: $eloquent->product_id,
            type: $eloquent->type,
            price: $eloquent->price,
            durationMonths: $eloquent->duration_months,
            startsAt: $eloquent->starts_at?->toImmutable(),
            expiresAt: $eloquent->expires_at?->toImmutable(),
            createdAt: $eloquent->created_at?->toImmutable(),
            updatedAt: $eloquent->updated_at?->toImmutable(),
        );
    }
}

