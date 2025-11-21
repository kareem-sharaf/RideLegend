<?php

namespace App\Domain\TradeIn\Events;

use App\Domain\Shared\Events\DomainEvent;
use App\Domain\TradeIn\Models\TradeIn;

class TradeInRejected extends DomainEvent
{
    public function __construct(
        public readonly TradeIn $tradeIn,
        public readonly ?string $reason = null
    ) {
        parent::__construct();
    }
}

