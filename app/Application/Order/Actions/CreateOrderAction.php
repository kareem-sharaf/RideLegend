<?php

namespace App\Application\Order\Actions;

use App\Application\Order\DTOs\CreateOrderDTO;
use App\Domain\Order\Models\Order;
use App\Domain\Order\Models\OrderItem;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Domain\Order\ValueObjects\OrderNumber;
use App\Domain\Product\ValueObjects\Price;
use App\Domain\Shipping\Models\ShippingAddress;
use Illuminate\Contracts\Events\Dispatcher;

class CreateOrderAction
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private Dispatcher $eventDispatcher,
    ) {}

    public function execute(CreateOrderDTO $dto): Order
    {
        $orderNumber = OrderNumber::generate();

        $subtotal = Price::fromAmount($dto->subtotal, $dto->currency);
        $tax = Price::fromAmount($dto->tax, $dto->currency);
        $shippingCost = Price::fromAmount($dto->shippingCost, $dto->currency);
        $discount = Price::fromAmount($dto->discount, $dto->currency);
        $total = Price::fromAmount($dto->total, $dto->currency);

        $order = Order::create(
            orderNumber: $orderNumber,
            buyerId: $dto->buyerId,
            subtotal: $subtotal,
            tax: $tax,
            shippingCost: $shippingCost,
            discount: $discount,
            total: $total,
            currency: $dto->currency
        );

        // Add order items from cart
        foreach ($dto->cartItems as $cartItem) {
            $unitPrice = $cartItem->getUnitPrice() 
                ?? Price::fromAmount(0, $dto->currency); // Fallback if no price

            $orderItem = OrderItem::create(
                productId: $cartItem->getProductId(),
                quantity: $cartItem->getQuantity(),
                unitPrice: $unitPrice
            );

            $order->addItem($orderItem);
        }

        // Save order
        $this->orderRepository->save($order);

        // Dispatch domain events
        foreach ($order->getDomainEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }

        $order->clearDomainEvents();

        return $order;
    }
}

