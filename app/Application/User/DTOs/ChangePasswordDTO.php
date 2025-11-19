<?php

namespace App\Application\User\DTOs;

final class ChangePasswordDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly string $currentPassword,
        public readonly string $newPassword,
        public readonly string $newPasswordConfirmation,
    ) {}

    public static function fromArray(int $userId, array $data): self
    {
        return new self(
            userId: $userId,
            currentPassword: $data['current_password'],
            newPassword: $data['new_password'],
            newPasswordConfirmation: $data['new_password_confirmation'] ?? $data['new_password'],
        );
    }
}

