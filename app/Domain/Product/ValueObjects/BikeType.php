<?php

namespace App\Domain\Product\ValueObjects;

use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

final class BikeType
{
    private const ALLOWED_TYPES = [
        'road',
        'mountain',
        'gravel',
        'hybrid',
        'electric',
        'bmx',
        'cruiser',
        'folding',
        'touring',
        'cyclocross',
    ];

    private function __construct(
        private readonly string $value
    ) {
        if (!in_array($value, self::ALLOWED_TYPES)) {
            throw new BusinessRuleViolationException(
                "Invalid bike type: {$value}",
                'INVALID_BIKE_TYPE'
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
            'road' => 'Road Bike',
            'mountain' => 'Mountain Bike',
            'gravel' => 'Gravel Bike',
            'hybrid' => 'Hybrid Bike',
            'electric' => 'Electric Bike',
            'bmx' => 'BMX',
            'cruiser' => 'Cruiser',
            'folding' => 'Folding Bike',
            'touring' => 'Touring Bike',
            'cyclocross' => 'Cyclocross',
            default => ucfirst($this->value),
        };
    }

    public function equals(BikeType $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

