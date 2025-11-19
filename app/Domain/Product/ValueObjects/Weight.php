<?php

namespace App\Domain\Product\ValueObjects;

use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

final class Weight
{
    private function __construct(
        private readonly float $value,
        private readonly string $unit = 'kg'
    ) {
        if ($value < 0) {
            throw new BusinessRuleViolationException(
                'Weight cannot be negative',
                'WEIGHT_NEGATIVE'
            );
        }

        if (!in_array($unit, ['kg', 'lbs'])) {
            throw new BusinessRuleViolationException(
                'Invalid weight unit. Must be kg or lbs',
                'INVALID_WEIGHT_UNIT'
            );
        }
    }

    public static function fromValue(float $value, string $unit = 'kg'): self
    {
        return new self($value, $unit);
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function toKilograms(): float
    {
        return $this->unit === 'lbs' ? $this->value * 0.453592 : $this->value;
    }

    public function equals(Weight $other): bool
    {
        return $this->toKilograms() === $other->toKilograms();
    }

    public function __toString(): string
    {
        return number_format($this->value, 2) . ' ' . $this->unit;
    }
}

