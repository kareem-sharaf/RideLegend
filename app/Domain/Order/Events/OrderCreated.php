<?php

namespace App\Domain\Order\Events;

use App\Domain\Order\Models\Order;
use App\Domain\Shared\Events\DomainEvent;

class OrderCreated extends DomainEvent
{
    public function __construct(
        public readonly Order $order
    ) {
        parent::__construct();
    }
}

