<?php

namespace App\Infrastructure\Services\Otp\Strategies;

// This is a placeholder - integrate with actual SMS service (Twilio, etc.)
class SmsOtpStrategy implements OtpStrategyInterface
{
    public function send(string $identifier, string $otp): void
    {
        // TODO: Integrate with SMS service
        // For now, just log it
        \Log::info("SMS OTP sent to {$identifier}: {$otp}");
    }

    public function getName(): string
    {
        return 'sms';
    }
}

