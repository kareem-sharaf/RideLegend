<?php

namespace App\Application\Admin\Inspections\Actions;

use App\Application\Admin\Inspections\DTOs\ApproveInspectionDTO;
use App\Domain\Inspection\Repositories\InspectionRepositoryInterface;

class ApproveInspectionAction
{
    public function __construct(
        private InspectionRepositoryInterface $inspectionRepository,
    ) {}

    public function execute(ApproveInspectionDTO $dto): void
    {
        $inspection = $this->inspectionRepository->findById($dto->inspectionId);

        if (!$inspection) {
            throw new \DomainException('Inspection not found');
        }

        // Update inspection status to approved
        $eloquentInspection = \App\Models\Inspection::find($dto->inspectionId);
        $eloquentInspection->status = 'completed';
        $eloquentInspection->save();
    }
}

