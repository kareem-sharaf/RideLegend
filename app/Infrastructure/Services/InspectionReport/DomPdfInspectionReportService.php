<?php

namespace App\Infrastructure\Services\InspectionReport;

use App\Domain\Inspection\Models\Inspection;
use App\Domain\Product\Models\Product;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;

class DomPdfInspectionReportService implements InspectionReportPdfServiceInterface
{
    public function generate(Inspection $inspection, Product $product): string
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('inspection.report-pdf', [
            'inspection' => $inspection,
            'product' => $product,
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "certifications/{$product->getId()}/inspection-{$inspection->getId()}-" . time() . '.pdf';
        $path = Storage::disk('public')->put($filename, $dompdf->output());

        return $filename;
    }
}

