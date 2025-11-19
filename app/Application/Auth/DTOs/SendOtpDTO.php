<?php

namespace App\Application\Auth\DTOs;

final class SendOtpDTO
{
    public function __construct(
        public readonly string $identifier, // email or phone
        public readonly string $channel, // 'email' or 'sms'
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            identifier: $data['identifier'],
            channel: $data['channel'] ?? 'email',
        );
    }
}

