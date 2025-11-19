<?php

namespace App\Application\Inspection\Actions;

use App\Application\Inspection\DTOs\SubmitInspectionReportDTO;
use App\Domain\Inspection\Events\InspectionCompleted;
use App\Domain\Inspection\Models\Inspection;
use App\Domain\Inspection\Repositories\InspectionRepositoryInterface;
use App\Domain\Inspection\ValueObjects\BrakeCondition;
use App\Domain\Inspection\ValueObjects\FrameCondition;
use App\Domain\Inspection\ValueObjects\GroupsetCondition;
use App\Domain\Inspection\ValueObjects\OverallGrade;
use App\Domain\Inspection\ValueObjects\WheelsCondition;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;
use Illuminate\Contracts\Events\Dispatcher;

class SubmitInspectionReportAction
{
    public function __construct(
        private InspectionRepositoryInterface $inspectionRepository,
        private Dispatcher $eventDispatcher
    ) {}

    public function execute(SubmitInspectionReportDTO $dto): Inspection
    {
        $inspection = $this->inspectionRepository->findById($dto->inspectionId);

        if ($inspection === null) {
            throw new BusinessRuleViolationException(
                'Inspection not found',
                'INSPECTION_NOT_FOUND'
            );
        }

        $frameCondition = FrameCondition::create($dto->frameGrade, $dto->frameNotes);
        $brakeCondition = BrakeCondition::create($dto->brakeGrade, $dto->brakeNotes);
        $groupsetCondition = GroupsetCondition::create($dto->groupsetGrade, $dto->groupsetNotes);
        $wheelsCondition = WheelsCondition::create($dto->wheelsGrade, $dto->wheelsNotes);
        $overallGrade = OverallGrade::fromString($dto->overallGrade);

        $inspection->submitReport(
            frameCondition: $frameCondition,
            brakeCondition: $brakeCondition,
            groupsetCondition: $groupsetCondition,
            wheelsCondition: $wheelsCondition,
            overallGrade: $overallGrade,
            notes: $dto->notes
        );

        $inspection = $this->inspectionRepository->save($inspection);

        // Dispatch domain events
        $inspection->getDomainEvents()->each(function ($event) {
            $this->eventDispatcher->dispatch($event);
        });
        $inspection->clearDomainEvents();

        return $inspection;
    }
}

