<?php

namespace App\Application\Product\Actions;

use App\Domain\Product\Models\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\ProductImage;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;
use App\Infrastructure\Services\ProductImage\ProductImageServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class UploadProductImagesAction
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductImageServiceInterface $imageService
    ) {}

    public function execute(int $productId, array $files, ?int $primaryIndex = null): Product
    {
        $product = $this->productRepository->findById($productId);

        if ($product === null) {
            throw new BusinessRuleViolationException(
                'Product not found',
                'PRODUCT_NOT_FOUND'
            );
        }

        $images = new Collection();
        $order = $product->getImages()->count();

        foreach ($files as $index => $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $path = $this->imageService->store($file, $productId);
            $isPrimary = ($primaryIndex !== null && $index === $primaryIndex) || ($primaryIndex === null && $index === 0);

            $images->push(ProductImage::create($path, $isPrimary, $order++));
        }

        // Merge with existing images
        $existingImages = $product->getImages();
        $allImages = $existingImages->merge($images);

        $product->setImages($allImages);

        return $this->productRepository->save($product);
    }
}

