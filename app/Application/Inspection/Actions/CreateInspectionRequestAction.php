<?php

namespace App\Application\Inspection\Actions;

use App\Application\Inspection\DTOs\CreateInspectionRequestDTO;
use App\Domain\Inspection\Events\InspectionRequested;
use App\Domain\Inspection\Models\Inspection;
use App\Domain\Inspection\Repositories\InspectionRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

class CreateInspectionRequestAction
{
    public function __construct(
        private InspectionRepositoryInterface $inspectionRepository,
        private Dispatcher $eventDispatcher
    ) {}

    public function execute(CreateInspectionRequestDTO $dto): Inspection
    {
        $inspection = Inspection::create(
            productId: $dto->productId,
            sellerId: $dto->sellerId,
            workshopId: $dto->workshopId
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

