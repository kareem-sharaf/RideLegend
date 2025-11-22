<?php

namespace App\Infrastructure\Services\Export;

interface ExportServiceInterface
{
    /**
     * Export data to CSV
     * 
     * @param array $data
     * @param array $headers
     * @return string File path or content
     */
    public function exportToCsv(array $data, array $headers = []): string;

    /**
     * Export data to PDF
     * 
     * @param array $data
     * @param string $template
     * @return string File path or content
     */
    public function exportToPdf(array $data, string $template): string;
}

