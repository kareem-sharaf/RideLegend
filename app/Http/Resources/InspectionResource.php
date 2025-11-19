<?php

namespace App\Http\Resources;

use App\Domain\Inspection\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InspectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Inspection $inspection */
        $inspection = $this->resource;

        return [
            'id' => $inspection->getId(),
            'product_id' => $inspection->getProductId(),
            'seller_id' => $inspection->getSellerId(),
            'workshop_id' => $inspection->getWorkshopId(),
            'status' => $inspection->getStatus(),
            'frame_condition' => $inspection->getFrameCondition() ? [
                'grade' => $inspection->getFrameCondition()->getGrade(),
                'display' => $inspection->getFrameCondition()->getDisplayName(),
                'notes' => $inspection->getFrameCondition()->getNotes(),
            ] : null,
            'brake_condition' => $inspection->getBrakeCondition() ? [
                'grade' => $inspection->getBrakeCondition()->getGrade(),
                'display' => $inspection->getBrakeCondition()->getDisplayName(),
                'notes' => $inspection->getBrakeCondition()->getNotes(),
            ] : null,
            'groupset_condition' => $inspection->getGroupsetCondition() ? [
                'grade' => $inspection->getGroupsetCondition()->getGrade(),
                'display' => $inspection->getGroupsetCondition()->getDisplayName(),
                'notes' => $inspection->getGroupsetCondition()->getNotes(),
            ] : null,
            'wheels_condition' => $inspection->getWheelsCondition() ? [
                'grade' => $inspection->getWheelsCondition()->getGrade(),
                'display' => $inspection->getWheelsCondition()->getDisplayName(),
                'notes' => $inspection->getWheelsCondition()->getNotes(),
            ] : null,
            'overall_grade' => $inspection->getOverallGrade()?->toString(),
            'notes' => $inspection->getNotes(),
            'images' => $inspection->getImages()->map(fn($path) => asset('storage/' . $path))->toArray(),
            'is_completed' => $inspection->isCompleted(),
            'requested_at' => $inspection->getId() ? now()->toIso8601String() : null,
        ];
    }
}

