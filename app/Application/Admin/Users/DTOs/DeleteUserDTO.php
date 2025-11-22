<?php

namespace App\Application\Admin\Users\DTOs;

readonly class DeleteUserDTO
{
    public function __construct(
        public int $userId,
        public int $adminId, // To prevent self-deletion
    ) {}
}

