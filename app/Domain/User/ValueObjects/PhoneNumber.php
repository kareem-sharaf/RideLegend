<?php

namespace App\Domain\User\ValueObjects;

use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

final class PhoneNumber
{
    private function __construct(
        private readonly string $value
    ) {
        // Basic validation - can be enhanced
        $cleaned = preg_replace('/[^0-9+]/', '', $value);
        if (strlen($cleaned) < 10) {
            throw new BusinessRuleViolationException(
                "Invalid phone number format: {$value}",
                'INVALID_PHONE_FORMAT'
            );
        }
    }

    public static function fromString(string $phoneNumber): self
    {
        return new self($phoneNumber);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(PhoneNumber $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

