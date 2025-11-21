<?php

namespace App\Domain\Order\Models;

use App\Domain\Product\ValueObjects\Price;

class OrderItem
{
    public function __construct(
        private ?int $id,
        private int $productId,
        private int $quantity,
        private Price $unitPrice,
        private Price $totalPrice,
    ) {}

    public static function create(
        int $productId,
        int $quantity,
        Price $unitPrice
    ): self {
        $totalPrice = Price::fromAmount($unitPrice->getAmount() * $quantity, $unitPrice->getCurrency());

        return new self(
            id: null,
            productId: $productId,
            quantity: $quantity,
            unitPrice: $unitPrice,
            totalPrice: $totalPrice,
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnitPrice(): Price
    {
        return $this->unitPrice;
    }

    public function getTotalPrice(): Price
    {
        return $this->totalPrice;
    }
}

