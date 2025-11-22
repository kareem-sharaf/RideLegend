<?php

namespace App\Infrastructure\Services\Export;

class CsvExportService implements ExportServiceInterface
{
    public function exportToCsv(array $data, array $headers = []): string
    {
        $filename = 'export_' . date('Y-m-d_His') . '.csv';
        $filepath = storage_path('app/exports/' . $filename);

        // Ensure directory exists
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }

        $file = fopen($filepath, 'w');

        // Write headers if provided
        if (!empty($headers)) {
            fputcsv($file, $headers);
        }

        // Write data
        foreach ($data as $row) {
            if (is_array($row)) {
                fputcsv($file, $row);
            } else {
                fputcsv($file, (array)$row);
            }
        }

        fclose($file);

        return $filepath;
    }

    public function exportToPdf(array $data, string $template): string
    {
        throw new \BadMethodCallException('PDF export not supported by CsvExportService. Use PdfExportService instead.');
    }
}

