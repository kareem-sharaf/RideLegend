<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Models\User;
use App\Domain\User\ValueObjects\Email;

interface UserRepositoryInterface
{
    public function save(User $user): User;

    public function findById(int $id): ?User;

    public function findByEmail(Email $email): ?User;

    public function delete(User $user): void;
}

