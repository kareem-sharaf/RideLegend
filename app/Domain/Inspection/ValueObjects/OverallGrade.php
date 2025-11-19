<?php

namespace App\Domain\Inspection\ValueObjects;

use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

final class OverallGrade
{
    private const ALLOWED_GRADES = ['A+', 'A', 'B', 'C'];

    private function __construct(
        private readonly string $value
    ) {
        if (!in_array($value, self::ALLOWED_GRADES)) {
            throw new BusinessRuleViolationException(
                "Invalid overall grade: {$value}",
                'INVALID_OVERALL_GRADE'
            );
        }
    }

    public static function fromString(string $grade): self
    {
        return new self($grade);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function getNumericValue(): int
    {
        return match ($this->value) {
            'A+' => 4,
            'A' => 3,
            'B' => 2,
            'C' => 1,
            default => 0,
        };
    }

    public function equals(OverallGrade $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

