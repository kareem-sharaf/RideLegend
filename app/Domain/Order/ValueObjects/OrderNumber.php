<?php

namespace App\Domain\Order\ValueObjects;

final class OrderNumber
{
    private function __construct(
        private readonly string $value
    ) {
        if (empty($value)) {
            throw new \InvalidArgumentException('Order number cannot be empty');
        }

        if (strlen($value) > 50) {
            throw new \InvalidArgumentException('Order number cannot exceed 50 characters');
        }
    }

    public static function generate(): self
    {
        $prefix = 'ORD';
        $timestamp = now()->format('Ymd');
        $random = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        
        return new self("{$prefix}-{$timestamp}-{$random}");
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(OrderNumber $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

