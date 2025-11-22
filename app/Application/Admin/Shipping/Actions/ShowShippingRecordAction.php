<?php

namespace App\Application\Admin\Shipping\Actions;

use App\Application\Admin\Shipping\DTOs\ShowShippingRecordDTO;
use App\Domain\Shipping\Repositories\ShippingRepositoryInterface;

class ShowShippingRecordAction
{
    public function __construct(
        private ShippingRepositoryInterface $shippingRepository,
    ) {}

    public function execute(ShowShippingRecordDTO $dto)
    {
        $shipping = $this->shippingRepository->findById($dto->shippingId);

        if (!$shipping) {
            throw new \DomainException('Shipping record not found');
        }

        return $shipping;
    }
}

