<?php

namespace App\Application\Admin\TradeIns\DTOs;

readonly class ListTradeInsDTO
{
    public function __construct(
        public ?string $status = null,
        public ?string $search = null,
        public ?int $buyerId = null,
        public ?string $dateFrom = null,
        public ?string $dateTo = null,
        public string $sortBy = 'created_at',
        public string $sortDirection = 'desc',
        public int $page = 1,
        public int $perPage = 15,
    ) {}
}

