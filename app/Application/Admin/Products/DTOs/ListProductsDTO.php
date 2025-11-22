<?php

namespace App\Application\Admin\Products\DTOs;

readonly class ListProductsDTO
{
    public function __construct(
        public ?string $status = null,
        public ?string $search = null,
        public ?int $sellerId = null,
        public ?int $categoryId = null,
        public ?float $minPrice = null,
        public ?float $maxPrice = null,
        public ?string $dateFrom = null,
        public ?string $dateTo = null,
        public string $sortBy = 'created_at',
        public string $sortDirection = 'desc',
        public int $page = 1,
        public int $perPage = 15,
    ) {}
}

