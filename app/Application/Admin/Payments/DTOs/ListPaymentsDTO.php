<?php

namespace App\Application\Admin\Payments\DTOs;

readonly class ListPaymentsDTO
{
    public function __construct(
        public ?string $status = null,
        public ?string $paymentMethod = null,
        public ?string $search = null,
        public ?int $userId = null,
        public ?int $orderId = null,
        public ?string $dateFrom = null,
        public ?string $dateTo = null,
        public ?float $minAmount = null,
        public ?float $maxAmount = null,
        public string $sortBy = 'created_at',
        public string $sortDirection = 'desc',
        public int $page = 1,
        public int $perPage = 15,
    ) {}
}

