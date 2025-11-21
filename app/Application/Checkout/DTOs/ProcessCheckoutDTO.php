<?php

namespace App\Application\Checkout\DTOs;

readonly class ProcessCheckoutDTO
{
    public function __construct(
        public int $userId,
        public string $shippingAddressLine1,
        public string $shippingAddressLine2,
        public string $shippingCity,
        public string $shippingState,
        public string $shippingPostalCode,
        public string $shippingCountry,
        public ?string $billingAddressLine1 = null,
        public ?string $billingAddressLine2 = null,
        public ?string $billingCity = null,
        public ?string $billingState = null,
        public ?string $billingPostalCode = null,
        public ?string $billingCountry = null,
        public ?string $paymentMethod = null,
        public ?array $paymentData = null,
        public ?float $shippingCost = null,
        public ?float $discount = null,
        public float $taxRate = 0.0,
    ) {}
}

