<?php

namespace App\Application\Admin\Users\Actions;

use App\Application\Admin\Users\DTOs\DeleteUserDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;

class DeleteUserAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function execute(DeleteUserDTO $dto): void
    {
        if ($dto->userId === $dto->adminId) {
            throw new \DomainException('You cannot delete your own account');
        }

        $user = $this->userRepository->findById($dto->userId);

        if (!$user) {
            throw new \DomainException('User not found');
        }

        \App\Models\User::destroy($dto->userId);
    }
}

