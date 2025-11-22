<?php

namespace App\Application\Admin\Orders\Actions;

use App\Application\Admin\Orders\DTOs\UpdateOrderStatusDTO;
use App\Application\Order\Actions\UpdateOrderStatusAction as OrderUpdateStatusAction;
use App\Application\Order\DTOs\UpdateOrderStatusDTO as OrderUpdateStatusDTO;

class UpdateOrderStatusAction
{
    public function __construct(
        private OrderUpdateStatusAction $orderUpdateStatusAction,
    ) {}

    public function execute(UpdateOrderStatusDTO $dto): void
    {
        $orderDTO = new OrderUpdateStatusDTO(
            orderId: $dto->orderId,
            status: $dto->status,
        );

        $this->orderUpdateStatusAction->execute($orderDTO);
    }
}

