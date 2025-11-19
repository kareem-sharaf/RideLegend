<?php

namespace App\Domain\Product\ValueObjects;

use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

final class FrameMaterial
{
    private const ALLOWED_MATERIALS = [
        'carbon',
        'aluminum',
        'steel',
        'titanium',
        'titanium_carbon',
    ];

    private function __construct(
        private readonly string $value
    ) {
        if (!in_array($value, self::ALLOWED_MATERIALS)) {
            throw new BusinessRuleViolationException(
                "Invalid frame material: {$value}",
                'INVALID_FRAME_MATERIAL'
            );
        }
    }

    public static function fromString(string $material): self
    {
        return new self($material);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function getDisplayName(): string
    {
        return match ($this->value) {
            'carbon' => 'Carbon Fiber',
            'aluminum' => 'Aluminum',
            'steel' => 'Steel',
            'titanium' => 'Titanium',
            'titanium_carbon' => 'Titanium Carbon',
            default => ucfirst($this->value),
        };
    }

    public function equals(FrameMaterial $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

