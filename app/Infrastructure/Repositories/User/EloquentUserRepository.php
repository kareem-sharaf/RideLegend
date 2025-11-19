<?php

namespace App\Infrastructure\Repositories\User;

use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\PhoneNumber;
use App\Models\User as EloquentUser;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function save(User $user): User
    {
        $eloquent = EloquentUser::updateOrCreate(
            ['id' => $user->getId()],
            [
                'email' => $user->getEmail()->toString(),
                'password' => $user->getPassword(),
                'role' => $user->getRole(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'phone' => $user->getPhone()?->toString(),
                'avatar' => $user->getAvatar(),
                'email_verified_at' => $user->isEmailVerified() ? now() : null,
            ]
        );

        return $this->toDomain($eloquent);
    }

    public function findById(int $id): ?User
    {
        $eloquent = EloquentUser::find($id);

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findByEmail(Email $email): ?User
    {
        $eloquent = EloquentUser::where('email', $email->toString())->first();

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function delete(User $user): void
    {
        if ($user->getId()) {
            EloquentUser::destroy($user->getId());
        }
    }

    private function toDomain(EloquentUser $eloquent): User
    {
        return new User(
            id: $eloquent->id,
            email: Email::fromString($eloquent->email),
            password: $eloquent->password,
            role: $eloquent->role ?? 'buyer',
            firstName: $eloquent->first_name,
            lastName: $eloquent->last_name,
            phone: $eloquent->phone ? PhoneNumber::fromString($eloquent->phone) : null,
            avatar: $eloquent->avatar,
            emailVerifiedAt: $eloquent->email_verified_at ? \DateTimeImmutable::createFromMutable($eloquent->email_verified_at) : null,
            createdAt: $eloquent->created_at ? \DateTimeImmutable::createFromMutable($eloquent->created_at) : null,
            updatedAt: $eloquent->updated_at ? \DateTimeImmutable::createFromMutable($eloquent->updated_at) : null,
        );
    }
}

