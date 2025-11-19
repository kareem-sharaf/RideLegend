<?php

namespace App\Application\Auth\Actions;

use App\Application\Auth\DTOs\SendOtpDTO;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;
use App\Infrastructure\Services\Otp\OtpServiceInterface;

class SendOtpAction
{
    public function __construct(
        private OtpServiceInterface $otpService
    ) {}

    public function execute(SendOtpDTO $dto): string
    {
        // Validate channel
        if (!in_array($dto->channel, ['email', 'sms'])) {
            throw new BusinessRuleViolationException(
                'Invalid OTP channel. Must be email or sms',
                'INVALID_OTP_CHANNEL'
            );
        }

        // Generate and send OTP
        $otp = $this->otpService->generate($dto->identifier);
        $this->otpService->send($dto->identifier, $otp, $dto->channel);

        return $otp; // In production, don't return OTP
    }
}

