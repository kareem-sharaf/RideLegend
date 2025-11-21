<?php

namespace App\Infrastructure\Services\Shipping;

class ShippingServiceFactory
{
    public function __construct(
        private DHLService $dhlService,
        private AramexService $aramexService,
        private LocalCourierService $localCourierService,
    ) {}

    public function create(string $carrier): ShippingServiceInterface
    {
        return match (strtolower($carrier)) {
            'dhl' => $this->dhlService,
            'aramex' => $this->aramexService,
            'local_courier', 'local' => $this->localCourierService,
            default => throw new \InvalidArgumentException("Unsupported carrier: {$carrier}"),
        };
    }
}

