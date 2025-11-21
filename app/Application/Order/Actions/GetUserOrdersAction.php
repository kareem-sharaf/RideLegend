<?php

namespace App\Application\Order\Actions;

use App\Application\Order\DTOs\GetUserOrdersDTO;
use App\Domain\Order\Repositories\OrderRepositoryInterface;

class GetUserOrdersAction
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
    ) {}

    public function execute(GetUserOrdersDTO $dto): array
    {
        return $this->orderRepository->findByBuyerId($dto->userId);
    }
}

