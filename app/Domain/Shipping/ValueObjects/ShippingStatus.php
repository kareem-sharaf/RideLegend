<?php

namespace App\Domain\Shipping\ValueObjects;

final class ShippingStatus
{
    private const PENDING = 'pending';
    private const LABEL_CREATED = 'label_created';
    private const PICKED_UP = 'picked_up';
    private const IN_TRANSIT = 'in_transit';
    private const OUT_FOR_DELIVERY = 'out_for_delivery';
    private const DELIVERED = 'delivered';
    private const EXCEPTION = 'exception';

    private function __construct(
        private readonly string $value
    ) {
        $allowed = [
            self::PENDING,
            self::LABEL_CREATED,
            self::PICKED_UP,
            self::IN_TRANSIT,
            self::OUT_FOR_DELIVERY,
            self::DELIVERED,
            self::EXCEPTION,
        ];

        if (!in_array($value, $allowed, true)) {
            throw new \InvalidArgumentException("Invalid shipping status: {$value}");
        }
    }

    public static function pending(): self
    {
        return new self(self::PENDING);
    }

    public static function labelCreated(): self
    {
        return new self(self::LABEL_CREATED);
    }

    public static function pickedUp(): self
    {
        return new self(self::PICKED_UP);
    }

    public static function inTransit(): self
    {
        return new self(self::IN_TRANSIT);
    }

    public static function outForDelivery(): self
    {
        return new self(self::OUT_FOR_DELIVERY);
    }

    public static function delivered(): self
    {
        return new self(self::DELIVERED);
    }

    public static function exception(): self
    {
        return new self(self::EXCEPTION);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(ShippingStatus $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

