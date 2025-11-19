<?php

namespace App\Application\User\Actions;

use App\Application\User\DTOs\UpdateUserProfileDTO;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\PhoneNumber;

class UpdateUserProfileAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(UpdateUserProfileDTO $dto): User
    {
        $user = $this->userRepository->findById($dto->userId);

        if ($user === null) {
            throw new BusinessRuleViolationException(
                'User not found',
                'USER_NOT_FOUND'
            );
        }

        $phone = $dto->phone ? PhoneNumber::fromString($dto->phone) : null;

        $user->updateProfile(
            firstName: $dto->firstName,
            lastName: $dto->lastName,
            phone: $phone
        );

        return $this->userRepository->save($user);
    }
}

