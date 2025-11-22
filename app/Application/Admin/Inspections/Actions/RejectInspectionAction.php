<?php

namespace App\Application\Admin\Inspections\Actions;

use App\Application\Admin\Inspections\DTOs\RejectInspectionDTO;
use App\Domain\Inspection\Repositories\InspectionRepositoryInterface;

class RejectInspectionAction
{
    public function __construct(
        private InspectionRepositoryInterface $inspectionRepository,
    ) {}

    public function execute(RejectInspectionDTO $dto): void
    {
        $inspection = $this->inspectionRepository->findById($dto->inspectionId);

        if (!$inspection) {
            throw new \DomainException('Inspection not found');
        }

        // Update inspection status to rejected
        $eloquentInspection = \App\Models\Inspection::find($dto->inspectionId);
        $eloquentInspection->status = 'rejected';
        $eloquentInspection->rejection_reason = $dto->reason;
        $eloquentInspection->save();
    }
}

