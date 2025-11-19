<?php

namespace App\Infrastructure\Services\InspectionReport;

use App\Domain\Inspection\Models\Inspection;
use App\Domain\Product\Models\Product;

interface InspectionReportPdfServiceInterface
{
    public function generate(Inspection $inspection, Product $product): string;
}

