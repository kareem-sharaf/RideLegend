<?php

namespace App\Infrastructure\Services\Payments;

class PaymentServiceFactory
{
    public function __construct(
        private StripeService $stripeService,
        private PayPalService $paypalService,
        private LocalGatewayService $localGatewayService,
    ) {}

    public function create(string $paymentMethod): PaymentServiceInterface
    {
        return match ($paymentMethod) {
            'stripe', 'credit_card' => $this->stripeService,
            'paypal' => $this->paypalService,
            'local_gateway', 'bank_transfer' => $this->localGatewayService,
            default => throw new \InvalidArgumentException("Unsupported payment method: {$paymentMethod}"),
        };
    }
}

