<?php

namespace App\Infrastructure\Services\Payments;

class LocalGatewayService implements PaymentServiceInterface
{
    public function __construct(
        private ?string $apiKey = null,
        private ?string $apiUrl = null,
    ) {
        $this->apiKey = $apiKey ?? config('services.local_gateway.api_key');
        $this->apiUrl = $apiUrl ?? config('services.local_gateway.api_url');
    }

    public function initializePayment(float $amount, string $currency, array $metadata = []): array
    {
        // TODO: Implement actual local gateway API call
        // For now, return mock response
        $transactionId = 'LOCAL-' . uniqid();
        
        return [
            'id' => $transactionId,
            'transaction_id' => $transactionId,
            'status' => 'pending',
            'payment_url' => $this->apiUrl . '/pay/' . $transactionId,
            'amount' => $amount,
            'currency' => $currency,
            'metadata' => $metadata,
        ];
    }

    public function confirmPayment(string $paymentIntentId, array $gatewayResponse = []): array
    {
        // TODO: Implement actual local gateway API call to confirm payment
        // For now, return mock response
        return [
            'id' => $paymentIntentId,
            'transaction_id' => $paymentIntentId,
            'status' => 'completed',
            'amount' => $gatewayResponse['amount'] ?? 0,
            'currency' => $gatewayResponse['currency'] ?? 'USD',
        ];
    }

    public function refundPayment(string $transactionId, ?float $amount = null): array
    {
        // TODO: Implement actual local gateway API call for refund
        // For now, return mock response
        $refundId = 'REFUND-' . uniqid();
        
        return [
            'id' => $refundId,
            'transaction_id' => $transactionId,
            'status' => 'refunded',
            'amount' => $amount,
        ];
    }
}

