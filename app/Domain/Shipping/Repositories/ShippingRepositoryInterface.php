<?php

namespace App\Domain\Shipping\Repositories;

use App\Domain\Shipping\Models\Shipping;

interface ShippingRepositoryInterface
{
    public function save(Shipping $shipping): void;

    public function findById(int $id): ?Shipping;

    public function findByOrderId(int $orderId): ?Shipping;

    public function findByTrackingNumber(string $trackingNumber): ?Shipping;
}

