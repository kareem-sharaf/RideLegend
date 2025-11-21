<?php

namespace App\Application\Shipping\Actions;

use App\Application\Shipping\DTOs\TrackShipmentDTO;
use App\Domain\Shipping\Repositories\ShippingRepositoryInterface;
use App\Infrastructure\Services\Shipping\ShippingServiceInterface;
use App\Infrastructure\Services\Shipping\ShippingServiceFactory;

class TrackShipmentAction
{
    public function __construct(
        private ShippingRepositoryInterface $shippingRepository,
        private ShippingServiceFactory $shippingServiceFactory,
    ) {}

    public function execute(TrackShipmentDTO $dto): array
    {
        $shipping = $this->shippingRepository->findByTrackingNumber($dto->trackingNumber);

        if (!$shipping) {
            throw new \DomainException('Shipping record not found');
        }

        // Get appropriate shipping service
        $shippingService = $this->shippingServiceFactory->create($shipping->getCarrier());

        // Track shipment with carrier
        $trackingInfo = $shippingService->trackShipment($dto->trackingNumber);

        return [
            'shipping' => $shipping,
            'tracking_info' => $trackingInfo,
        ];
    }
}

