<?php

namespace App\Domain\TradeIn\ValueObjects;

final class TradeInStatus
{
    private const PENDING = 'pending';
    private const VALUATED = 'valuated';
    private const APPROVED = 'approved';
    private const REJECTED = 'rejected';
    private const COMPLETED = 'completed';

    private function __construct(
        private readonly string $value
    ) {
        $allowed = [
            self::PENDING,
            self::VALUATED,
            self::APPROVED,
            self::REJECTED,
            self::COMPLETED,
        ];

        if (!in_array($value, $allowed, true)) {
            throw new \InvalidArgumentException("Invalid trade-in status: {$value}");
        }
    }

    public static function pending(): self
    {
        return new self(self::PENDING);
    }

    public static function valuated(): self
    {
        return new self(self::VALUATED);
    }

    public static function approved(): self
    {
        return new self(self::APPROVED);
    }

    public static function rejected(): self
    {
        return new self(self::REJECTED);
    }

    public static function completed(): self
    {
        return new self(self::COMPLETED);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isPending(): bool
    {
        return $this->value === self::PENDING;
    }

    public function isValuated(): bool
    {
        return $this->value === self::VALUATED;
    }

    public function isApproved(): bool
    {
        return $this->value === self::APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->value === self::REJECTED;
    }

    public function isCompleted(): bool
    {
        return $this->value === self::COMPLETED;
    }

    public function equals(TradeInStatus $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

