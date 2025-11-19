<?php

namespace App\Infrastructure\Repositories\Inspection;

use App\Domain\Inspection\Models\Inspection;
use App\Domain\Inspection\Repositories\InspectionRepositoryInterface;
use App\Domain\Inspection\ValueObjects\BrakeCondition;
use App\Domain\Inspection\ValueObjects\FrameCondition;
use App\Domain\Inspection\ValueObjects\GroupsetCondition;
use App\Domain\Inspection\ValueObjects\OverallGrade;
use App\Domain\Inspection\ValueObjects\WheelsCondition;
use App\Models\Inspection as EloquentInspection;
use Illuminate\Support\Collection;

class EloquentInspectionRepository implements InspectionRepositoryInterface
{
    public function save(Inspection $inspection): Inspection
    {
        $eloquent = EloquentInspection::updateOrCreate(
            ['id' => $inspection->getId()],
            [
                'product_id' => $inspection->getProductId(),
                'seller_id' => $inspection->getSellerId(),
                'workshop_id' => $inspection->getWorkshopId(),
                'status' => $inspection->getStatus(),
                'frame_grade' => $inspection->getFrameCondition()?->getGrade(),
                'frame_notes' => $inspection->getFrameCondition()?->getNotes(),
                'brake_grade' => $inspection->getBrakeCondition()?->getGrade(),
                'brake_notes' => $inspection->getBrakeCondition()?->getNotes(),
                'groupset_grade' => $inspection->getGroupsetCondition()?->getGrade(),
                'groupset_notes' => $inspection->getGroupsetCondition()?->getNotes(),
                'wheels_grade' => $inspection->getWheelsCondition()?->getGrade(),
                'wheels_notes' => $inspection->getWheelsCondition()?->getNotes(),
                'overall_grade' => $inspection->getOverallGrade()?->toString(),
                'notes' => $inspection->getNotes(),
                'requested_at' => $inspection->getId() ? null : now(),
                'scheduled_at' => null,
                'completed_at' => $inspection->isCompleted() ? now() : null,
            ]
        );

        // Save images
        if ($inspection->getImages()->isNotEmpty()) {
            $eloquent->images()->delete();
            foreach ($inspection->getImages() as $path) {
                $eloquent->images()->create(['path' => $path]);
            }
        }

        return $this->toDomain($eloquent);
    }

    public function findById(int $id): ?Inspection
    {
        $eloquent = EloquentInspection::with('images')->find($id);

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findByProductId(int $productId): ?Inspection
    {
        $eloquent = EloquentInspection::with('images')
            ->where('product_id', $productId)
            ->first();

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findByWorkshopId(int $workshopId): Collection
    {
        $eloquents = EloquentInspection::with('images')
            ->where('workshop_id', $workshopId)
            ->get();

        return $eloquents->map(fn($eloquent) => $this->toDomain($eloquent));
    }

    public function findByStatus(string $status): Collection
    {
        $eloquents = EloquentInspection::with('images')
            ->where('status', $status)
            ->get();

        return $eloquents->map(fn($eloquent) => $this->toDomain($eloquent));
    }

    public function delete(Inspection $inspection): void
    {
        if ($inspection->getId()) {
            EloquentInspection::destroy($inspection->getId());
        }
    }

    private function toDomain(EloquentInspection $eloquent): Inspection
    {
        $images = $eloquent->images->pluck('path');

        $inspection = new Inspection(
            id: $eloquent->id,
            productId: $eloquent->product_id,
            sellerId: $eloquent->seller_id,
            workshopId: $eloquent->workshop_id,
            status: $eloquent->status ?? 'pending',
            frameCondition: $eloquent->frame_grade ? FrameCondition::create($eloquent->frame_grade, $eloquent->frame_notes) : null,
            brakeCondition: $eloquent->brake_grade ? BrakeCondition::create($eloquent->brake_grade, $eloquent->brake_notes) : null,
            groupsetCondition: $eloquent->groupset_grade ? GroupsetCondition::create($eloquent->groupset_grade, $eloquent->groupset_notes) : null,
            wheelsCondition: $eloquent->wheels_grade ? WheelsCondition::create($eloquent->wheels_grade, $eloquent->wheels_notes) : null,
            overallGrade: $eloquent->overall_grade ? OverallGrade::fromString($eloquent->overall_grade) : null,
            notes: $eloquent->notes,
            requestedAt: $eloquent->requested_at ? \DateTimeImmutable::createFromMutable($eloquent->requested_at) : null,
            scheduledAt: $eloquent->scheduled_at ? \DateTimeImmutable::createFromMutable($eloquent->scheduled_at) : null,
            completedAt: $eloquent->completed_at ? \DateTimeImmutable::createFromMutable($eloquent->completed_at) : null,
            createdAt: $eloquent->created_at ? \DateTimeImmutable::createFromMutable($eloquent->created_at) : null,
            updatedAt: $eloquent->updated_at ? \DateTimeImmutable::createFromMutable($eloquent->updated_at) : null,
        );

        $inspection->setImages($images);

        return $inspection;
    }
}

