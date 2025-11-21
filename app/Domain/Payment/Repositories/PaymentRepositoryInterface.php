<?php

namespace App\Domain\Payment\Repositories;

use App\Domain\Payment\Models\Payment;

interface PaymentRepositoryInterface
{
    public function save(Payment $payment): void;

    public function findById(int $id): ?Payment;

    public function findByOrderId(int $orderId): array;

    public function findByTransactionId(string $transactionId): ?Payment;
}

