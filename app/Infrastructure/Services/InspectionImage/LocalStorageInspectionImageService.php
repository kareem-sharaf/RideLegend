<?php

namespace App\Infrastructure\Services\InspectionImage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalStorageInspectionImageService implements InspectionImageServiceInterface
{
    public function store(UploadedFile $file, int $inspectionId): string
    {
        $path = $file->store("inspections/{$inspectionId}", 'public');

        return $path;
    }

    public function delete(string $path): void
    {
        Storage::disk('public')->delete($path);
    }
}

