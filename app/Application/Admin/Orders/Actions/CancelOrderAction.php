<?php

namespace App\Application\Admin\Orders\Actions;

use App\Application\Admin\Orders\DTOs\CancelOrderDTO;
use App\Application\Order\Actions\CancelOrderAction as OrderCancelAction;
use App\Application\Order\DTOs\CancelOrderDTO as OrderCancelDTO;
use App\Domain\Order\Repositories\OrderRepositoryInterface;

class CancelOrderAction
{
    public function __construct(
        private OrderCancelAction $orderCancelAction,
        private OrderRepositoryInterface $orderRepository,
    ) {}

    public function execute(CancelOrderDTO $dto): void
    {
        $order = $this->orderRepository->findById($dto->orderId);

        if (!$order) {
            throw new \DomainException('Order not found');
        }

        // Admin can cancel any order
        $orderCancelDTO = new OrderCancelDTO(
            orderId: $dto->orderId,
            userId: $order->getBuyerId(), // Use order's buyer ID
        );

        $this->orderCancelAction->execute($orderCancelDTO);
    }
}

