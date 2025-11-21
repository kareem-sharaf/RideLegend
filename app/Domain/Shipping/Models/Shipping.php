<?php

namespace App\Domain\Shipping\Models;

use App\Domain\Product\ValueObjects\Price;
use App\Domain\Shipping\ValueObjects\ShippingStatus;

class Shipping
{
    public function __construct(
        private ?int $id,
        private int $orderId,
        private string $carrier,
        private string $serviceType,
        private ShippingStatus $status,
        private ?string $trackingNumber = null,
        private Price $cost = null,
        private ?\DateTimeImmutable $shippedAt = null,
        private ?\DateTimeImmutable $deliveredAt = null,
        private ?\DateTimeImmutable $createdAt = null,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
        if ($cost === null) {
            $this->cost = Price::fromAmount(0.00);
        }
    }

    public static function create(
        int $orderId,
        string $carrier,
        string $serviceType,
        Price $cost
    ): self {
        return new self(
            id: null,
            orderId: $orderId,
            carrier: $carrier,
            serviceType: $serviceType,
            status: ShippingStatus::pending(),
            cost: $cost,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    public function getServiceType(): string
    {
        return $this->serviceType;
    }

    public function getStatus(): ShippingStatus
    {
        return $this->status;
    }

    public function getTrackingNumber(): ?string
    {
        return $this->trackingNumber;
    }

    public function getCost(): Price
    {
        return $this->cost;
    }

    public function getShippedAt(): ?\DateTimeImmutable
    {
        return $this->shippedAt;
    }

    public function getDeliveredAt(): ?\DateTimeImmutable
    {
        return $this->deliveredAt;
    }

    public function createLabel(string $trackingNumber): void
    {
        $this->trackingNumber = $trackingNumber;
        $this->status = ShippingStatus::labelCreated();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function markAsPickedUp(): void
    {
        $this->status = ShippingStatus::pickedUp();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function markAsInTransit(): void
    {
        $this->status = ShippingStatus::inTransit();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function markAsOutForDelivery(): void
    {
        $this->status = ShippingStatus::outForDelivery();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function markAsDelivered(): void
    {
        $this->status = ShippingStatus::delivered();
        $this->deliveredAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function markAsException(): void
    {
        $this->status = ShippingStatus::exception();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function changeStatus(ShippingStatus $newStatus): void
    {
        $this->status = $newStatus;
        $this->updatedAt = new \DateTimeImmutable();
    }
}

