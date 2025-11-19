<?php

namespace App\Domain\Product\ValueObjects;

use App\Domain\Shared\Exceptions\BusinessRuleViolationException;

final class Title
{
    private function __construct(
        private readonly string $value
    ) {
        if (empty(trim($value))) {
            throw new BusinessRuleViolationException(
                'Product title cannot be empty',
                'TITLE_EMPTY'
            );
        }

        if (strlen($value) > 255) {
            throw new BusinessRuleViolationException(
                'Product title cannot exceed 255 characters',
                'TITLE_TOO_LONG'
            );
        }
    }

    public static function fromString(string $title): self
    {
        return new self($title);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(Title $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

