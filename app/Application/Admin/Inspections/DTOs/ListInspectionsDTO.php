<?php

namespace App\Application\Admin\Inspections\DTOs;

readonly class ListInspectionsDTO
{
    public function __construct(
        public ?string $status = null,
        public ?string $search = null,
        public ?int $workshopId = null,
        public ?int $productId = null,
        public ?string $dateFrom = null,
        public ?string $dateTo = null,
        public string $sortBy = 'created_at',
        public string $sortDirection = 'desc',
        public int $page = 1,
        public int $perPage = 15,
    ) {}
}

