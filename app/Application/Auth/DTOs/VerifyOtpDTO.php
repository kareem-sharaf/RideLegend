<?php

namespace App\Application\Auth\DTOs;

final class VerifyOtpDTO
{
    public function __construct(
        public readonly string $identifier,
        public readonly string $otp,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            identifier: $data['identifier'],
            otp: $data['otp'],
        );
    }
}

