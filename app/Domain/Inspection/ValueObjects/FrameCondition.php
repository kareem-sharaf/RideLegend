<?php

namespace App\Domain\Inspection\ValueObjects;

use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

final class FrameCondition
{
    private const ALLOWED_GRADES = ['excellent', 'very_good', 'good', 'fair', 'poor'];

    private function __construct(
        private readonly string $grade,
        private readonly ?string $notes = null
    ) {
        if (!in_array($grade, self::ALLOWED_GRADES)) {
            throw new BusinessRuleViolationException(
                "Invalid frame condition grade: {$grade}",
                'INVALID_FRAME_CONDITION'
            );
        }
    }

    public static function create(string $grade, ?string $notes = null): self
    {
        return new self($grade, $notes);
    }

    public function getGrade(): string
    {
        return $this->grade;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getDisplayName(): string
    {
        return match ($this->grade) {
            'excellent' => 'Excellent',
            'very_good' => 'Very Good',
            'good' => 'Good',
            'fair' => 'Fair',
            'poor' => 'Poor',
            default => ucfirst($this->grade),
        };
    }

    public function equals(FrameCondition $other): bool
    {
        return $this->grade === $other->grade;
    }
}

