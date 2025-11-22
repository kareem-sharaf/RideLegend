<?php

namespace App\Application\Admin\Users\DTOs;

readonly class ShowUserDTO
{
    public function __construct(
        public int $userId,
    ) {}
}

