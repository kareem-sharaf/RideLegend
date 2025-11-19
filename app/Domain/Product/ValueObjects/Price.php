<?php

namespace App\Domain\Product\ValueObjects;

use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

final class Price
{
    private function __construct(
        private readonly float $amount,
        private readonly string $currency = 'USD'
    ) {
        if ($amount < 0) {
            throw new BusinessRuleViolationException(
                'Price cannot be negative',
                'PRICE_NEGATIVE'
            );
        }

        if ($amount > 1000000) {
            throw new BusinessRuleViolationException(
                'Price exceeds maximum allowed value',
                'PRICE_TOO_HIGH'
            );
        }
    }

    public static function fromAmount(float $amount, string $currency = 'USD'): self
    {
        return new self($amount, $currency);
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function equals(Price $other): bool
    {
        return $this->amount === $other->amount && $this->currency === $other->currency;
    }

    public function __toString(): string
    {
        return number_format($this->amount, 2) . ' ' . $this->currency;
    }
}

