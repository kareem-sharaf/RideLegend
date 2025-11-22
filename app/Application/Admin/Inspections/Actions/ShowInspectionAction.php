<?php

namespace App\Application\Admin\Inspections\Actions;

use App\Application\Admin\Inspections\DTOs\ShowInspectionDTO;
use App\Domain\Inspection\Repositories\InspectionRepositoryInterface;

class ShowInspectionAction
{
    public function __construct(
        private InspectionRepositoryInterface $inspectionRepository,
    ) {}

    public function execute(ShowInspectionDTO $dto)
    {
        $inspection = $this->inspectionRepository->findById($dto->inspectionId);

        if (!$inspection) {
            throw new \DomainException('Inspection not found');
        }

        return $inspection;
    }
}

