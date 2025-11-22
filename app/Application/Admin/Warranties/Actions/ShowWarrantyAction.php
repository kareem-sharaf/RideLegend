<?php

namespace App\Application\Admin\Warranties\Actions;

use App\Application\Admin\Warranties\DTOs\ShowWarrantyDTO;
use App\Domain\Warranty\Repositories\WarrantyRepositoryInterface;

class ShowWarrantyAction
{
    public function __construct(
        private WarrantyRepositoryInterface $warrantyRepository,
    ) {}

    public function execute(ShowWarrantyDTO $dto)
    {
        $warranty = $this->warrantyRepository->findById($dto->warrantyId);

        if (!$warranty) {
            throw new \DomainException('Warranty not found');
        }

        return $warranty;
    }
}

