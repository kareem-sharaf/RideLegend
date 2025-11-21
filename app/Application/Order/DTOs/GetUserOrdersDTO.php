<?php

namespace App\Application\Order\DTOs;

readonly class GetUserOrdersDTO
{
    public function __construct(
        public int $userId,
        public ?string $status = null,
        public int $page = 1,
        public int $perPage = 15,
    ) {}
}

