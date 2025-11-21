<?php

namespace App\Infrastructure\Repositories\Shipping;

use App\Domain\Product\ValueObjects\Price;
use App\Domain\Shipping\Models\Shipping;
use App\Domain\Shipping\Repositories\ShippingRepositoryInterface;
use App\Domain\Shipping\ValueObjects\ShippingStatus;
use App\Models\Shipping as EloquentShipping;

class EloquentShippingRepository implements ShippingRepositoryInterface
{
    public function save(Shipping $shipping): void
    {
        $eloquent = EloquentShipping::updateOrCreate(
            ['id' => $shipping->getId()],
            [
                'order_id' => $shipping->getOrderId(),
                'carrier' => $shipping->getCarrier(),
                'service_type' => $shipping->getServiceType(),
                'status' => $shipping->getStatus()->getValue(),
                'tracking_number' => $shipping->getTrackingNumber(),
                'cost' => $shipping->getCost()->getAmount(),
                'shipped_at' => $shipping->getShippedAt(),
                'delivered_at' => $shipping->getDeliveredAt(),
            ]
        );

        // Update shipping ID in domain model if it was new
        if (!$shipping->getId()) {
            $reflection = new \ReflectionClass($shipping);
            $idProperty = $reflection->getProperty('id');
            $idProperty->setAccessible(true);
            $idProperty->setValue($shipping, $eloquent->id);
        }
    }

    public function findById(int $id): ?Shipping
    {
        $eloquent = EloquentShipping::find($id);

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findByOrderId(int $orderId): ?Shipping
    {
        $eloquent = EloquentShipping::where('order_id', $orderId)->first();

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findByTrackingNumber(string $trackingNumber): ?Shipping
    {
        $eloquent = EloquentShipping::where('tracking_number', $trackingNumber)->first();

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    private function toDomain(EloquentShipping $eloquent): Shipping
    {
        $status = ShippingStatus::fromString($eloquent->status);
        $cost = Price::fromAmount($eloquent->cost);

        return new Shipping(
            id: $eloquent->id,
            orderId: $eloquent->order_id,
            carrier: $eloquent->carrier,
            serviceType: $eloquent->service_type,
            status: $status,
            trackingNumber: $eloquent->tracking_number,
            cost: $cost,
            shippedAt: $eloquent->shipped_at?->toImmutable(),
            deliveredAt: $eloquent->delivered_at?->toImmutable(),
            createdAt: $eloquent->created_at?->toImmutable(),
            updatedAt: $eloquent->updated_at?->toImmutable(),
        );
    }
}

