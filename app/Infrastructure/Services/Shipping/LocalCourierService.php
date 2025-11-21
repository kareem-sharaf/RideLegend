<?php

namespace App\Infrastructure\Services\Shipping;

class LocalCourierService implements ShippingServiceInterface
{
    public function __construct(
        private ?string $apiKey = null,
        private ?string $apiUrl = null,
    ) {
        $this->apiKey = $apiKey ?? config('services.local_courier.api_key');
        $this->apiUrl = $apiUrl ?? config('services.local_courier.api_url');
    }

    public function createShipment(array $shipmentData): array
    {
        // TODO: Implement actual local courier API call
        // For now, return mock response
        $trackingNumber = 'LOCAL' . strtoupper(uniqid());
        
        return [
            'tracking_number' => $trackingNumber,
            'label_url' => $this->apiUrl . '/labels/' . $trackingNumber,
            'status' => 'label_created',
            'carrier' => 'Local Courier',
        ];
    }

    public function trackShipment(string $trackingNumber): array
    {
        // TODO: Implement actual local courier API call for tracking
        // For now, return mock response
        return [
            'tracking_number' => $trackingNumber,
            'status' => 'in_transit',
            'carrier' => 'Local Courier',
            'events' => [
                [
                    'timestamp' => now()->toIso8601String(),
                    'location' => 'Origin Facility',
                    'description' => 'Shipment picked up',
                ],
            ],
        ];
    }

    public function updateStatus(string $trackingNumber, string $status): array
    {
        // TODO: Implement actual local courier API call to update status
        return [
            'tracking_number' => $trackingNumber,
            'status' => $status,
            'updated_at' => now()->toIso8601String(),
        ];
    }
}

