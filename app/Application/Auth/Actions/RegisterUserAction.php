<?php

namespace App\Application\Auth\Actions;

use App\Application\Auth\DTOs\RegisterUserDTO;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;
use App\Domain\User\Events\UserRegistered;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\PhoneNumber;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private Dispatcher $eventDispatcher
    ) {}

    public function execute(RegisterUserDTO $dto): User
    {
        // Validate password confirmation
        if ($dto->password !== $dto->passwordConfirmation) {
            throw new BusinessRuleViolationException(
                'Password confirmation does not match',
                'PASSWORD_MISMATCH'
            );
        }

        // Check if user already exists
        $email = Email::fromString($dto->email);
        $existingUser = $this->userRepository->findByEmail($email);
        if ($existingUser !== null) {
            throw new BusinessRuleViolationException(
                'User with this email already exists',
                'USER_ALREADY_EXISTS'
            );
        }

        // Validate role
        $allowedRoles = ['buyer', 'seller', 'workshop', 'admin'];
        if (!in_array($dto->role, $allowedRoles)) {
            throw new BusinessRuleViolationException(
                'Invalid role specified',
                'INVALID_ROLE'
            );
        }

        // Create user
        $phone = $dto->phone ? PhoneNumber::fromString($dto->phone) : null;
        $hashedPassword = Hash::make($dto->password);

        $user = User::create(
            email: $email,
            password: $hashedPassword,
            role: $dto->role,
            firstName: $dto->firstName,
            lastName: $dto->lastName,
            phone: $phone
        );

        // Save user
        $user = $this->userRepository->save($user);

        // Dispatch domain events
        $user->getDomainEvents()->each(function ($event) {
            $this->eventDispatcher->dispatch($event);
        });
        $user->clearDomainEvents();

        return $user;
    }
}

