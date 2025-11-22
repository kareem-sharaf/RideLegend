<?php

namespace App\Application\Admin\Orders\DTOs;

readonly class ListOrdersDTO
{
    public function __construct(
        public ?string $status = null,
        public ?string $search = null,
        public ?int $buyerId = null,
        public ?string $dateFrom = null,
        public ?string $dateTo = null,
        public ?float $minTotal = null,
        public ?float $maxTotal = null,
        public string $sortBy = 'created_at',
        public string $sortDirection = 'desc',
        public int $page = 1,
        public int $perPage = 15,
    ) {}
}

