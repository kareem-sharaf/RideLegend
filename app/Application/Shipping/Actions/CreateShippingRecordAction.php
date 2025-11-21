<?php

namespace App\Application\Shipping\Actions;

use App\Application\Shipping\DTOs\CreateShippingRecordDTO;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Domain\Product\ValueObjects\Price;
use App\Domain\Shipping\Models\Shipping;
use App\Domain\Shipping\Repositories\ShippingRepositoryInterface;

class CreateShippingRecordAction
{
    public function __construct(
        private ShippingRepositoryInterface $shippingRepository,
        private OrderRepositoryInterface $orderRepository,
    ) {}

    public function execute(CreateShippingRecordDTO $dto): Shipping
    {
        // Validate order exists
        $order = $this->orderRepository->findById($dto->orderId);
        
        if (!$order) {
            throw new \DomainException('Order not found');
        }

        $cost = Price::fromAmount($dto->cost, $dto->currency);

        $shipping = Shipping::create(
            orderId: $dto->orderId,
            carrier: $dto->carrier,
            serviceType: $dto->serviceType,
            cost: $cost
        );

        $this->shippingRepository->save($shipping);

        return $shipping;
    }
}

