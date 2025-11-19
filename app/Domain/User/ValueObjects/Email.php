<?php

namespace App\Domain\User\ValueObjects;

use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

final class Email
{
    private function __construct(
        private readonly string $value
    ) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new BusinessRuleViolationException(
                "Invalid email format: {$value}",
                'INVALID_EMAIL_FORMAT'
            );
        }
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(Email $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

