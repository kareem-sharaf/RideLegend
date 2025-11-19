<?php

namespace App\Infrastructure\Services\Otp;

use Illuminate\Support\Facades\Cache;

class CacheOtpService implements OtpServiceInterface
{
    private const OTP_EXPIRY_MINUTES = 10;
    private const OTP_LENGTH = 6;

    public function __construct(
        private OtpStrategyFactory $strategyFactory
    ) {}

    public function generate(string $identifier): string
    {
        $otp = str_pad((string) random_int(0, 999999), self::OTP_LENGTH, '0', STR_PAD_LEFT);

        // Store OTP in cache
        Cache::put(
            $this->getCacheKey($identifier),
            $otp,
            now()->addMinutes(self::OTP_EXPIRY_MINUTES)
        );

        return $otp;
    }

    public function send(string $identifier, string $otp, string $channel): void
    {
        $strategy = $this->strategyFactory->create($channel);
        $strategy->send($identifier, $otp);
    }

    public function verify(string $identifier, string $otp): bool
    {
        $cachedOtp = Cache::get($this->getCacheKey($identifier));

        if ($cachedOtp === null) {
            return false;
        }

        if ($cachedOtp !== $otp) {
            return false;
        }

        // Remove OTP after successful verification
        Cache::forget($this->getCacheKey($identifier));

        return true;
    }

    private function getCacheKey(string $identifier): string
    {
        return "otp:{$identifier}";
    }
}

