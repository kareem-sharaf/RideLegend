<?php

namespace App\Application\Order\Actions;

use App\Application\Order\DTOs\UpdateOrderStatusDTO;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Domain\Order\ValueObjects\OrderStatus;
use Illuminate\Contracts\Events\Dispatcher;

class UpdateOrderStatusAction
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private Dispatcher $eventDispatcher,
    ) {}

    public function execute(UpdateOrderStatusDTO $dto): void
    {
        $order = $this->orderRepository->findById($dto->orderId);

        if (!$order) {
            throw new \DomainException('Order not found');
        }

        $newStatus = OrderStatus::fromString($dto->status);

        // Use domain methods for status transitions
        match ($dto->status) {
            'confirmed' => $order->confirm(),
            'processing' => $order->markAsProcessing(),
            'shipped' => $order->markAsShipped(),
            'delivered' => $order->markAsDelivered(),
            'cancelled' => $order->cancel(),
            default => $order->changeStatus($newStatus),
        };

        $this->orderRepository->save($order);

        // Dispatch domain events
        foreach ($order->getDomainEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }

        $order->clearDomainEvents();
    }
}

