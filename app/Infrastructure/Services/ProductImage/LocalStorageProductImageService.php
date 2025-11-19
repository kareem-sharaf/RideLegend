<?php

namespace App\Infrastructure\Services\ProductImage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalStorageProductImageService implements ProductImageServiceInterface
{
    public function store(UploadedFile $file, int $productId): string
    {
        $path = $file->store("products/{$productId}", 'public');

        return $path;
    }

    public function delete(string $path): void
    {
        Storage::disk('public')->delete($path);
    }
}

