<?php

namespace App\Infrastructure\Services\Payments;

interface PaymentServiceInterface
{
    /**
     * Initialize payment with gateway
     * 
     * @param float $amount
     * @param string $currency
     * @param array $metadata Additional payment metadata
     * @return array Gateway response with payment intent/session ID
     */
    public function initializePayment(float $amount, string $currency, array $metadata = []): array;

    /**
     * Confirm payment after gateway callback
     * 
     * @param string $paymentIntentId Payment intent/session ID from gateway
     * @param array $gatewayResponse Full gateway response
     * @return array Confirmation response
     */
    public function confirmPayment(string $paymentIntentId, array $gatewayResponse = []): array;

    /**
     * Refund a payment
     * 
     * @param string $transactionId Original transaction ID
     * @param float|null $amount Amount to refund (null for full refund)
     * @return array Refund response
     */
    public function refundPayment(string $transactionId, ?float $amount = null): array;
}

