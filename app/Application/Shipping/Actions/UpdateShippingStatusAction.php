<?php

namespace App\Application\Shipping\Actions;

use App\Application\Shipping\DTOs\UpdateShippingStatusDTO;
use App\Domain\Shipping\Repositories\ShippingRepositoryInterface;
use App\Domain\Shipping\ValueObjects\ShippingStatus;

class UpdateShippingStatusAction
{
    public function __construct(
        private ShippingRepositoryInterface $shippingRepository,
    ) {}

    public function execute(UpdateShippingStatusDTO $dto): void
    {
        $shipping = $this->shippingRepository->findById($dto->shippingId);

        if (!$shipping) {
            throw new \DomainException('Shipping record not found');
        }

        $newStatus = ShippingStatus::fromString($dto->status);

        // Use domain methods for status transitions
        match ($dto->status) {
            'label_created' => $shipping->createLabel($dto->trackingNumber ?? ''),
            'picked_up' => $shipping->markAsPickedUp(),
            'in_transit' => $shipping->markAsInTransit(),
            'out_for_delivery' => $shipping->markAsOutForDelivery(),
            'delivered' => $shipping->markAsDelivered(),
            'exception' => $shipping->markAsException(),
            default => $shipping->changeStatus($newStatus),
        };

        $this->shippingRepository->save($shipping);
    }
}

