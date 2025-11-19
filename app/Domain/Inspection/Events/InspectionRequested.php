<?php

namespace App\Domain\Inspection\Events;

use App\Domain\Inspection\Models\Inspection;
use App\Domain\Shared\Events\DomainEvent;

class InspectionRequested extends DomainEvent
{
    public function __construct(
        public readonly Inspection $inspection
    ) {
        parent::__construct();
    }
}

