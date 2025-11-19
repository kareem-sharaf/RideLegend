<?php

namespace App\Application\User\Actions;

use App\Application\User\DTOs\ChangePasswordDTO;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(ChangePasswordDTO $dto): User
    {
        // Validate password confirmation
        if ($dto->newPassword !== $dto->newPasswordConfirmation) {
            throw new BusinessRuleViolationException(
                'Password confirmation does not match',
                'PASSWORD_MISMATCH'
            );
        }

        $user = $this->userRepository->findById($dto->userId);

        if ($user === null) {
            throw new BusinessRuleViolationException(
                'User not found',
                'USER_NOT_FOUND'
            );
        }

        // Verify current password
        if (!Hash::check($dto->currentPassword, $user->getPassword())) {
            throw new BusinessRuleViolationException(
                'Current password is incorrect',
                'INVALID_CURRENT_PASSWORD'
            );
        }

        // Update password
        $hashedPassword = Hash::make($dto->newPassword);
        $user->changePassword($hashedPassword);

        return $this->userRepository->save($user);
    }
}

