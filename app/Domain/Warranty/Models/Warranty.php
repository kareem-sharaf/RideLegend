<?php

namespace App\Domain\Warranty\Models;

use App\Domain\Product\ValueObjects\Price;

class Warranty
{
    public function __construct(
        private ?int $id,
        private int $orderId,
        private ?int $productId,
        private string $type,
        private Price $price,
        private int $durationMonths,
        private ?string $coverageDetails = null,
        private ?\DateTimeImmutable $startsAt = null,
        private ?\DateTimeImmutable $expiresAt = null,
        private string $status = 'active',
        private ?\DateTimeImmutable $createdAt = null,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {}

    public static function create(
        int $orderId,
        ?int $productId,
        string $type,
        Price $price,
        int $durationMonths,
        ?string $coverageDetails = null
    ): self {
        $now = new \DateTimeImmutable();
        $expiresAt = $now->modify("+{$durationMonths} months");

        return new self(
            id: null,
            orderId: $orderId,
            productId: $productId,
            type: $type,
            price: $price,
            durationMonths: $durationMonths,
            coverageDetails: $coverageDetails,
            startsAt: $now,
            expiresAt: $expiresAt,
            status: 'active',
            createdAt: $now,
            updatedAt: $now,
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

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getDurationMonths(): int
    {
        return $this->durationMonths;
    }

    public function getCoverageDetails(): ?string
    {
        return $this->coverageDetails;
    }

    public function getStartsAt(): ?\DateTimeImmutable
    {
        return $this->startsAt;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && 
               $this->expiresAt !== null && 
               $this->expiresAt > new \DateTimeImmutable();
    }

    public function expire(): void
    {
        $this->status = 'expired';
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function cancel(): void
    {
        $this->status = 'cancelled';
        $this->updatedAt = new \DateTimeImmutable();
    }
}

