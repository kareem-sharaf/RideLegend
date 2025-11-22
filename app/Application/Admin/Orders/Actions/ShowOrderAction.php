<?php

namespace App\Application\Admin\Orders\Actions;

use App\Application\Admin\Orders\DTOs\ShowOrderDTO;
use App\Domain\Order\Repositories\OrderRepositoryInterface;

class ShowOrderAction
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
    ) {}

    public function execute(ShowOrderDTO $dto)
    {
        $order = $this->orderRepository->findById($dto->orderId);

        if (!$order) {
            throw new \DomainException('Order not found');
        }

        return $order;
    }
}

