<?php

namespace App\Application\User\Actions;

use App\Domain\Shared\Exceptions\BusinessRuleViolationException;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadUserAvatarAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(int $userId, UploadedFile $file): User
    {
        $user = $this->userRepository->findById($userId);

        if ($user === null) {
            throw new BusinessRuleViolationException(
                'User not found',
                'USER_NOT_FOUND'
            );
        }

        // Validate file
        if (!$file->isValid()) {
            throw new BusinessRuleViolationException(
                'Invalid file uploaded',
                'INVALID_FILE'
            );
        }

        // Validate image type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new BusinessRuleViolationException(
                'Invalid image type. Allowed: JPEG, PNG, GIF, WebP',
                'INVALID_IMAGE_TYPE'
            );
        }

        // Delete old avatar if exists
        if ($user->getAvatar()) {
            Storage::disk('public')->delete($user->getAvatar());
        }

        // Store new avatar
        $path = $file->store('avatars', 'public');
        $user->updateAvatar($path);

        return $this->userRepository->save($user);
    }
}

