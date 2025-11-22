<?php

namespace App\Application\Admin\Warranties\DTOs;

readonly class ListWarrantiesDTO
{
    public function __construct(
        public ?string $status = null,
        public ?string $type = null,
        public ?string $search = null,
        public ?int $orderId = null,
        public ?int $productId = null,
        public ?string $dateFrom = null,
        public ?string $dateTo = null,
        public string $sortBy = 'created_at',
        public string $sortDirection = 'desc',
        public int $page = 1,
        public int $perPage = 15,
    ) {}
}

