<?php

namespace App\Domain\Order\Repositories;

use App\Domain\Order\Models\Order;
use App\Domain\Order\ValueObjects\OrderNumber;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;

    public function findById(int $id): ?Order;

    public function findByOrderNumber(OrderNumber $orderNumber): ?Order;

    public function findByBuyerId(int $buyerId): array;

    public function delete(Order $order): void;
}

