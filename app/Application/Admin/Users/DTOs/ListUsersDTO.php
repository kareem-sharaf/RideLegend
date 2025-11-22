<?php

namespace App\Application\Admin\Users\DTOs;

readonly class ListUsersDTO
{
    public function __construct(
        public ?string $role = null,
        public ?string $search = null,
        public ?string $status = null,
        public string $sortBy = 'created_at',
        public string $sortDirection = 'desc',
        public int $page = 1,
        public int $perPage = 15,
    ) {}
}
