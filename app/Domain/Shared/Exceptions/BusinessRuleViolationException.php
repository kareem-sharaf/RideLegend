<?php

namespace App\Domain\Shared\Exceptions;

class BusinessRuleViolationException extends DomainException
{
    public function __construct(
        string $message,
        private readonly string $rule,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getRule(): string
    {
        return $this->rule;
    }
}

