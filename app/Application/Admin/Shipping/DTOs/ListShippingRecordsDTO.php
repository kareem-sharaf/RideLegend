<?php

namespace App\Application\Admin\Shipping\DTOs;

readonly class ListShippingRecordsDTO
{
    public function __construct(
        public ?string $status = null,
        public ?string $carrier = null,
        public ?string $search = null,
        public ?int $orderId = null,
        public ?string $dateFrom = null,
        public ?string $dateTo = null,
        public string $sortBy = 'created_at',
        public string $sortDirection = 'desc',
        public int $page = 1,
        public int $perPage = 15,
    ) {}
}

