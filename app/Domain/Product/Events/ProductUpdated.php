<?php

namespace App\Domain\Product\Events;

use App\Domain\Product\Models\Product;
use App\Domain\Shared\Events\DomainEvent;

class ProductUpdated extends DomainEvent
{
    public function __construct(
        public readonly Product $product
    ) {
        parent::__construct();
    }
}

