<?php

namespace App\Application\Auth\Actions;

use App\Application\Auth\DTOs\LoginUserDTO;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;
use App\Domain\User\Events\UserLoggedIn;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\Email;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Hash;

class LoginUserAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private Dispatcher $eventDispatcher
    ) {}

    public function execute(LoginUserDTO $dto): User
    {
        $email = Email::fromString($dto->email);
        $user = $this->userRepository->findByEmail($email);

        if ($user === null) {
            throw new BusinessRuleViolationException(
                'Invalid credentials',
                'INVALID_CREDENTIALS'
            );
        }

        if (!Hash::check($dto->password, $user->getPassword())) {
            throw new BusinessRuleViolationException(
                'Invalid credentials',
                'INVALID_CREDENTIALS'
            );
        }

        // Dispatch domain event
        $this->eventDispatcher->dispatch(new UserLoggedIn($user));

        return $user;
    }
}

