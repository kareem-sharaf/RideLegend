<?php

namespace App\Domain\Order\ValueObjects;

final class OrderStatus
{
    private const PENDING = 'pending';
    private const CONFIRMED = 'confirmed';
    private const PROCESSING = 'processing';
    private const SHIPPED = 'shipped';
    private const DELIVERED = 'delivered';
    private const CANCELLED = 'cancelled';
    private const REFUNDED = 'refunded';
    private const DRAFT = 'draft';

    private function __construct(
        private readonly string $value
    ) {
        $allowed = [
            self::DRAFT,
            self::PENDING,
            self::CONFIRMED,
            self::PROCESSING,
            self::SHIPPED,
            self::DELIVERED,
            self::CANCELLED,
            self::REFUNDED,
        ];

        if (!in_array($value, $allowed, true)) {
            throw new \InvalidArgumentException("Invalid order status: {$value}");
        }
    }

    public static function draft(): self
    {
        return new self(self::DRAFT);
    }

    public static function pending(): self
    {
        return new self(self::PENDING);
    }

    public static function confirmed(): self
    {
        return new self(self::CONFIRMED);
    }

    public static function processing(): self
    {
        return new self(self::PROCESSING);
    }

    public static function shipped(): self
    {
        return new self(self::SHIPPED);
    }

    public static function delivered(): self
    {
        return new self(self::DELIVERED);
    }

    public static function cancelled(): self
    {
        return new self(self::CANCELLED);
    }

    public static function refunded(): self
    {
        return new self(self::REFUNDED);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isDraft(): bool
    {
        return $this->value === self::DRAFT;
    }

    public function isPending(): bool
    {
        return $this->value === self::PENDING;
    }

    public function isConfirmed(): bool
    {
        return $this->value === self::CONFIRMED;
    }

    public function isProcessing(): bool
    {
        return $this->value === self::PROCESSING;
    }

    public function isShipped(): bool
    {
        return $this->value === self::SHIPPED;
    }

    public function isDelivered(): bool
    {
        return $this->value === self::DELIVERED;
    }

    public function isCancelled(): bool
    {
        return $this->value === self::CANCELLED;
    }

    public function isRefunded(): bool
    {
        return $this->value === self::REFUNDED;
    }

    public function equals(OrderStatus $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

