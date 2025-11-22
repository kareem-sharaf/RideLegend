<?php

namespace App\Application\Admin\Inspections\DTOs;

readonly class RejectInspectionDTO
{
    public function __construct(
        public int $inspectionId,
        public string $reason,
    ) {}
}

