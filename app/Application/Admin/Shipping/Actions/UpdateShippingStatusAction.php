<?php

namespace App\Application\Admin\Shipping\Actions;

use App\Application\Admin\Shipping\DTOs\UpdateShippingStatusDTO;
use App\Application\Shipping\Actions\UpdateShippingStatusAction as ShippingUpdateStatusAction;
use App\Application\Shipping\DTOs\UpdateShippingStatusDTO as ShippingUpdateStatusDTO;

class UpdateShippingStatusAction
{
    public function __construct(
        private ShippingUpdateStatusAction $shippingUpdateStatusAction,
    ) {}

    public function execute(UpdateShippingStatusDTO $dto): void
    {
        $shippingUpdateStatusDTO = new ShippingUpdateStatusDTO(
            shippingId: $dto->shippingId,
            status: $dto->status,
            trackingNumber: $dto->trackingNumber,
        );

        $this->shippingUpdateStatusAction->execute($shippingUpdateStatusDTO);
    }
}

