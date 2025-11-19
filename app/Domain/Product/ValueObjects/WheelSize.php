<?php

namespace App\Domain\Product\ValueObjects;

use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

final class WheelSize
{
    private const ALLOWED_SIZES = [
        '12',
        '16',
        '20',
        '24',
        '26',
        '27.5',
        '29',
        '700c',
        '650b',
    ];

    private function __construct(
        private readonly string $value
    ) {
        if (!in_array($value, self::ALLOWED_SIZES)) {
            throw new BusinessRuleViolationException(
                "Invalid wheel size: {$value}",
                'INVALID_WHEEL_SIZE'
            );
        }
    }

    public static function fromString(string $size): self
    {
        return new self($size);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(WheelSize $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

