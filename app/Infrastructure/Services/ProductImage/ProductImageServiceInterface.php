<?php

namespace App\Infrastructure\Services\ProductImage;

use Illuminate\Http\UploadedFile;

interface ProductImageServiceInterface
{
    public function store(UploadedFile $file, int $productId): string;

    public function delete(string $path): void;
}

