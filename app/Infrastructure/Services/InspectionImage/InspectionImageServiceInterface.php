<?php

namespace App\Infrastructure\Services\InspectionImage;

use Illuminate\Http\UploadedFile;

interface InspectionImageServiceInterface
{
    public function store(UploadedFile $file, int $inspectionId): string;

    public function delete(string $path): void;
}

