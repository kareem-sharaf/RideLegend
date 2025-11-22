<?php

namespace App\Infrastructure\Services\Export;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfExportService implements ExportServiceInterface
{
    public function exportToCsv(array $data, array $headers = []): string
    {
        throw new \BadMethodCallException('CSV export not supported by PdfExportService. Use CsvExportService instead.');
    }

    public function exportToPdf(array $data, string $template): string
    {
        $html = view($template, ['data' => $data])->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'export_' . date('Y-m-d_His') . '.pdf';
        $filepath = storage_path('app/exports/' . $filename);

        // Ensure directory exists
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }

        file_put_contents($filepath, $dompdf->output());

        return $filepath;
    }
}

