<?php

namespace App\Domain\Order\Events;

use App\Domain\Order\Models\Order;
use App\Domain\Order\ValueObjects\OrderStatus;
use App\Domain\Shared\Events\DomainEvent;

class OrderStatusChanged extends DomainEvent
{
    public function __construct(
        public readonly Order $order,
        public readonly OrderStatus $oldStatus,
        public readonly OrderStatus $newStatus
    ) {
        parent::__construct();
    }
}

