<?php

namespace App\Infrastructure\Services\Otp;

use App\Infrastructure\Services\Otp\Strategies\EmailOtpStrategy;
use App\Infrastructure\Services\Otp\Strategies\OtpStrategyInterface;
use App\Infrastructure\Services\Otp\Strategies\SmsOtpStrategy;
use DomainException;

class OtpStrategyFactory
{
    public function create(string $channel): OtpStrategyInterface
    {
        return match ($channel) {
            'email' => new EmailOtpStrategy(),
            'sms' => new SmsOtpStrategy(),
            default => throw new DomainException("Unsupported OTP channel: {$channel}"),
        };
    }
}

