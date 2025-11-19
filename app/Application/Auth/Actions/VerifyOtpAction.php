<?php

namespace App\Application\Auth\Actions;

use App\Application\Auth\DTOs\VerifyOtpDTO;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;
use App\Infrastructure\Services\Otp\OtpServiceInterface;

class VerifyOtpAction
{
    public function __construct(
        private OtpServiceInterface $otpService
    ) {}

    public function execute(VerifyOtpDTO $dto): bool
    {
        $isValid = $this->otpService->verify($dto->identifier, $dto->otp);

        if (!$isValid) {
            throw new BusinessRuleViolationException(
                'Invalid or expired OTP',
                'INVALID_OTP'
            );
        }

        return true;
    }
}

