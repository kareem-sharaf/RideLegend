<?php

namespace App\Domain\TradeIn\Repositories;

use App\Domain\TradeIn\Models\TradeIn;

interface TradeInRepositoryInterface
{
    public function save(TradeIn $tradeIn): void;

    public function findById(int $id): ?TradeIn;

    public function findByBuyerId(int $buyerId): array;
}

