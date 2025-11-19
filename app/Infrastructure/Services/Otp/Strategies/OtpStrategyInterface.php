<?php

namespace App\Infrastructure\Services\Otp\Strategies;

interface OtpStrategyInterface
{
    public function send(string $identifier, string $otp): void;

    public function getName(): string;
}

