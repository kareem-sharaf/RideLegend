<?php

namespace App\Application\Shipping\DTOs;

readonly class TrackShipmentDTO
{
    public function __construct(
        public string $trackingNumber,
    ) {}
}

