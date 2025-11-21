<?php

namespace App\Application\Order\DTOs;

use App\Domain\Cart\Models\CartItem;

readonly class CreateOrderDTO
{
    /**
     * @param CartItem[] $cartItems
     */
    public function __construct(
        public int $buyerId,
        public array $cartItems,
        public float $subtotal,
        public float $tax,
        public float $shippingCost,
        public float $discount,
        public float $total,
        public string $shippingAddressLine1,
        public string $shippingAddressLine2,
        public string $shippingCity,
        public string $shippingState,
        public string $shippingPostalCode,
        public string $shippingCountry,
        public string $currency = 'USD',
    ) {}
}

