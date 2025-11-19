<?php

namespace App\Domain\Product\ValueObjects;

use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

final class BrakeType
{
    private const ALLOWED_TYPES = [
        'rim_brake',
        'disc_brake_mechanical',
        'disc_brake_hydraulic',
        'coaster_brake',
    ];

    private function __construct(
        private readonly string $value
    ) {
        if (!in_array($value, self::ALLOWED_TYPES)) {
            throw new BusinessRuleViolationException(
                "Invalid brake type: {$value}",
                'INVALID_BRAKE_TYPE'
            );
        }
    }

    public static function fromString(string $type): self
    {
        return new self($type);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function getDisplayName(): string
    {
        return match ($this->value) {
            'rim_brake' => 'Rim Brake',
            'disc_brake_mechanical' => 'Disc Brake (Mechanical)',
            'disc_brake_hydraulic' => 'Disc Brake (Hydraulic)',
            'coaster_brake' => 'Coaster Brake',
            default => ucfirst($this->value),
        };
    }

    public function equals(BrakeType $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

