<?php

namespace App\Application\Admin\Warranties\Actions;

use App\Application\Admin\Warranties\DTOs\UpdateWarrantyDTO;
use App\Domain\Warranty\Repositories\WarrantyRepositoryInterface;

class UpdateWarrantyAction
{
    public function __construct(
        private WarrantyRepositoryInterface $warrantyRepository,
    ) {}

    public function execute(UpdateWarrantyDTO $dto): void
    {
        $warranty = $this->warrantyRepository->findById($dto->warrantyId);

        if (!$warranty) {
            throw new \DomainException('Warranty not found');
        }

        if ($dto->status) {
            $eloquentWarranty = \App\Models\Warranty::find($dto->warrantyId);
            $eloquentWarranty->status = $dto->status;
            $eloquentWarranty->save();
        }
    }
}

