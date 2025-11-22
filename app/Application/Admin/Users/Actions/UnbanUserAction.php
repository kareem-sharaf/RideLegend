<?php

namespace App\Application\Admin\Users\Actions;

use App\Application\Admin\Users\DTOs\BanUserDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;

class UnbanUserAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function execute(BanUserDTO $dto): void
    {
        $user = $this->userRepository->findById($dto->userId);

        if (!$user) {
            throw new \DomainException('User not found');
        }

        $eloquentUser = \App\Models\User::find($dto->userId);
        $eloquentUser->email_verified_at = now();
        $eloquentUser->save();
    }
}

