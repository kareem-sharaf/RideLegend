<?php

namespace App\Application\Order\Actions;

use App\Application\Order\DTOs\CancelOrderDTO;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

class CancelOrderAction
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private Dispatcher $eventDispatcher,
    ) {}

    public function execute(CancelOrderDTO $dto): void
    {
        $order = $this->orderRepository->findById($dto->orderId);

        if (!$order) {
            throw new \DomainException('Order not found');
        }

        if ($order->getBuyerId() !== $dto->userId) {
            throw new \DomainException('Unauthorized: Order does not belong to user');
        }

        $order->cancel();
        $this->orderRepository->save($order);

        // Dispatch domain events
        foreach ($order->getDomainEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }

        $order->clearDomainEvents();
    }
}

