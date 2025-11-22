<?php

namespace App\Application\Admin\Users\Actions;

use App\Application\Admin\Users\DTOs\UpdateUserDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UpdateUserAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function execute(UpdateUserDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            $user = $this->userRepository->findById($dto->userId);

            if (!$user) {
                throw new \DomainException('User not found');
            }

            // Update user profile
            $eloquentUser = \App\Models\User::find($dto->userId);
            $eloquentUser->update([
                'first_name' => $dto->firstName,
                'last_name' => $dto->lastName,
                'email' => $dto->email,
                'phone' => $dto->phone,
            ]);

            // Update roles if provided
            if ($dto->roles !== null) {
                $eloquentUser->syncRoles($dto->roles);
            }
        });
    }
}

