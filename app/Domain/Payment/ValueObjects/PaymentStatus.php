<?php

namespace App\Domain\Payment\ValueObjects;

final class PaymentStatus
{
    private const PENDING = 'pending';
    private const PROCESSING = 'processing';
    private const COMPLETED = 'completed';
    private const FAILED = 'failed';
    private const REFUNDED = 'refunded';
    private const CANCELLED = 'cancelled';

    private function __construct(
        private readonly string $value
    ) {
        $allowed = [
            self::PENDING,
            self::PROCESSING,
            self::COMPLETED,
            self::FAILED,
            self::REFUNDED,
            self::CANCELLED,
        ];

        if (!in_array($value, $allowed, true)) {
            throw new \InvalidArgumentException("Invalid payment status: {$value}");
        }
    }

    public static function pending(): self
    {
        return new self(self::PENDING);
    }

    public static function processing(): self
    {
        return new self(self::PROCESSING);
    }

    public static function completed(): self
    {
        return new self(self::COMPLETED);
    }

    public static function failed(): self
    {
        return new self(self::FAILED);
    }

    public static function refunded(): self
    {
        return new self(self::REFUNDED);
    }

    public static function cancelled(): self
    {
        return new self(self::CANCELLED);
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

    public function isProcessing(): bool
    {
        return $this->value === self::PROCESSING;
    }

    public function isCompleted(): bool
    {
        return $this->value === self::COMPLETED;
    }

    public function isFailed(): bool
    {
        return $this->value === self::FAILED;
    }

    public function isRefunded(): bool
    {
        return $this->value === self::REFUNDED;
    }

    public function equals(PaymentStatus $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

