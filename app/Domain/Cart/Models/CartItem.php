<?php

namespace App\Domain\Cart\Models;

use App\Domain\Product\ValueObjects\Price;

class CartItem
{
    public function __construct(
        private ?int $id,
        private int $userId,
        private int $productId,
        private int $quantity,
        private ?Price $unitPrice = null,
        private ?\DateTimeImmutable $createdAt = null,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {}

    public static function create(
        int $userId,
        int $productId,
        int $quantity,
        ?Price $unitPrice = null
    ): self {
        return new self(
            id: null,
            userId: $userId,
            productId: $productId,
            quantity: $quantity,
            unitPrice: $unitPrice,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnitPrice(): ?Price
    {
        return $this->unitPrice;
    }

    public function updateQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new \DomainException('Quantity must be greater than zero');
        }

        $this->quantity = $quantity;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function incrementQuantity(int $amount = 1): void
    {
        $this->updateQuantity($this->quantity + $amount);
    }

    public function decrementQuantity(int $amount = 1): void
    {
        if ($this->quantity - $amount <= 0) {
            throw new \DomainException('Quantity cannot be zero or negative');
        }

        $this->updateQuantity($this->quantity - $amount);
    }
}

