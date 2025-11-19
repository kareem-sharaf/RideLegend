<?php

namespace App\Infrastructure\Services\Otp\Strategies;

use Illuminate\Support\Facades\Mail;

class EmailOtpStrategy implements OtpStrategyInterface
{
    public function send(string $identifier, string $otp): void
    {
        Mail::raw("Your OTP code is: {$otp}", function ($message) use ($identifier) {
            $message->to($identifier)
                ->subject('Your OTP Code');
        });
    }

    public function getName(): string
    {
        return 'email';
    }
}

