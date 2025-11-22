<?php

namespace App\Application\Admin\Inspections\DTOs;

readonly class ApproveInspectionDTO
{
    public function __construct(
        public int $inspectionId,
    ) {}
}

