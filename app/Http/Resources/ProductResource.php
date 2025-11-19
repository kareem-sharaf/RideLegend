<?php

namespace App\Http\Resources;

use App\Domain\Product\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Product $product */
        $product = $this->resource;

        return [
            'id' => $product->getId(),
            'seller_id' => $product->getSellerId(),
            'title' => $product->getTitle()->toString(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice()->getAmount(),
            'currency' => $product->getPrice()->getCurrency(),
            'bike_type' => $product->getBikeType()->toString(),
            'bike_type_display' => $product->getBikeType()->getDisplayName(),
            'frame_material' => $product->getFrameMaterial()->toString(),
            'frame_material_display' => $product->getFrameMaterial()->getDisplayName(),
            'brake_type' => $product->getBrakeType()->toString(),
            'brake_type_display' => $product->getBrakeType()->getDisplayName(),
            'wheel_size' => $product->getWheelSize()->toString(),
            'weight' => $product->getWeight()?->getValue(),
            'weight_unit' => $product->getWeight()?->getUnit(),
            'brand' => $product->getBrand(),
            'model' => $product->getModel(),
            'year' => $product->getYear(),
            'status' => $product->getStatus(),
            'category_id' => $product->getCategoryId(),
            'certification_id' => $product->getCertificationId(),
            'is_certified' => $product->isCertified(),
            'images' => $product->getImages()->map(function ($image) {
                return [
                    'path' => asset('storage/' . $image->getPath()),
                    'is_primary' => $image->isPrimary(),
                    'order' => $image->getOrder(),
                ];
            })->toArray(),
            'created_at' => $product->getId() ? now()->toIso8601String() : null,
        ];
    }
}

