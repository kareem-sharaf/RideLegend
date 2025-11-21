<?php

namespace App\Infrastructure\Services\Shipping;

interface ShippingServiceInterface
{
    /**
     * Create shipment with carrier
     * 
     * @param array $shipmentData Shipment details (order, address, items, etc.)
     * @return array Carrier response with tracking number and label
     */
    public function createShipment(array $shipmentData): array;

    /**
     * Track shipment
     * 
     * @param string $trackingNumber
     * @return array Tracking information
     */
    public function trackShipment(string $trackingNumber): array;

    /**
     * Update shipment status
     * 
     * @param string $trackingNumber
     * @param string $status
     * @return array Update response
     */
    public function updateStatus(string $trackingNumber, string $status): array;
}

