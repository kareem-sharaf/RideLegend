<?php

namespace App\Application\Inspection\DTOs;

final class SubmitInspectionReportDTO
{
    public function __construct(
        public readonly int $inspectionId,
        public readonly string $frameGrade,
        public readonly ?string $frameNotes = null,
        public readonly string $brakeGrade,
        public readonly ?string $brakeNotes = null,
        public readonly string $groupsetGrade,
        public readonly ?string $groupsetNotes = null,
        public readonly string $wheelsGrade,
        public readonly ?string $wheelsNotes = null,
        public readonly string $overallGrade,
        public readonly ?string $notes = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            inspectionId: $data['inspection_id'] ?? $data['inspectionId'],
            frameGrade: $data['frame_grade'] ?? $data['frameGrade'],
            frameNotes: $data['frame_notes'] ?? $data['frameNotes'] ?? null,
            brakeGrade: $data['brake_grade'] ?? $data['brakeGrade'],
            brakeNotes: $data['brake_notes'] ?? $data['brakeNotes'] ?? null,
            groupsetGrade: $data['groupset_grade'] ?? $data['groupsetGrade'],
            groupsetNotes: $data['groupset_notes'] ?? $data['groupsetNotes'] ?? null,
            wheelsGrade: $data['wheels_grade'] ?? $data['wheelsGrade'],
            wheelsNotes: $data['wheels_notes'] ?? $data['wheelsNotes'] ?? null,
            overallGrade: $data['overall_grade'] ?? $data['overallGrade'],
            notes: $data['notes'] ?? null,
        );
    }
}

