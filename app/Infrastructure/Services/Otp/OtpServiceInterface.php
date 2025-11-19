<?php

namespace App\Infrastructure\Services\Otp;

interface OtpServiceInterface
{
    public function generate(string $identifier): string;

    public function send(string $identifier, string $otp, string $channel): void;

    public function verify(string $identifier, string $otp): bool;
}

