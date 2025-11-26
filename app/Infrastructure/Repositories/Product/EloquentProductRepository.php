<?php

namespace App\Infrastructure\Repositories\Product;

use App\Domain\Product\Models\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\BikeType;
use App\Domain\Product\ValueObjects\BrakeType;
use App\Domain\Product\ValueObjects\FrameMaterial;
use App\Domain\Product\ValueObjects\Price;
use App\Domain\Product\ValueObjects\ProductImage;
use App\Domain\Product\ValueObjects\Title;
use App\Domain\Product\ValueObjects\Weight;
use App\Domain\Product\ValueObjects\WheelSize;
use App\Models\Product as EloquentProduct;
use Illuminate\Support\Collection;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function save(Product $product): Product
    {
        $eloquent = EloquentProduct::updateOrCreate(
            ['id' => $product->getId()],
            [
                'seller_id' => $product->getSellerId(),
                'title' => $product->getTitle()->toString(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice()->getAmount(),
                'bike_type' => $product->getBikeType()->toString(),
                'frame_material' => $product->getFrameMaterial()->toString(),
                'brake_type' => $product->getBrakeType()->toString(),
                'wheel_size' => $product->getWheelSize()->toString(),
                'weight' => $product->getWeight()?->getValue(),
                'weight_unit' => $product->getWeight()?->getUnit(),
                'brand' => $product->getBrand(),
                'model' => $product->getModel(),
                'year' => $product->getYear(),
                'status' => $product->getStatus(),
                'category_id' => $product->getCategoryId(),
                'certification_id' => $product->getCertificationId(),
            ]
        );

        // Save images
        if ($product->getImages()->isNotEmpty()) {
            $eloquent->images()->delete();
            foreach ($product->getImages() as $index => $image) {
                $eloquent->images()->create([
                    'path' => $image->getPath(),
                    'is_primary' => $image->isPrimary(),
                    'order' => $image->getOrder() ?: $index,
                ]);
            }
        }

        return $this->toDomain($eloquent);
    }

    public function findById(int $id): ?Product
    {
        $eloquent = EloquentProduct::with('images')->find($id);

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findBySellerId(int $sellerId): Collection
    {
        $eloquents = EloquentProduct::with('images')
            ->where('seller_id', $sellerId)
            ->get();

        return $eloquents->map(fn($eloquent) => $this->toDomain($eloquent));
    }

    public function findByCategoryId(int $categoryId): Collection
    {
        $eloquents = EloquentProduct::with('images')
            ->where('category_id', $categoryId)
            ->get();

        return $eloquents->map(fn($eloquent) => $this->toDomain($eloquent));
    }

    public function findByStatus(string $status): Collection
    {
        $eloquents = EloquentProduct::with('images')
            ->where('status', $status)
            ->get();

        return $eloquents->map(fn($eloquent) => $this->toDomain($eloquent));
    }

    public function search(array $criteria): Collection
    {
        $query = EloquentProduct::with('images');

        if (isset($criteria['category_id'])) {
            $query->where('category_id', $criteria['category_id']);
        }

        if (isset($criteria['bike_type'])) {
            $query->where('bike_type', $criteria['bike_type']);
        }

        if (isset($criteria['frame_material'])) {
            $query->where('frame_material', $criteria['frame_material']);
        }

        if (isset($criteria['brake_type'])) {
            $query->where('brake_type', $criteria['brake_type']);
        }

        if (isset($criteria['wheel_size'])) {
            $query->where('wheel_size', $criteria['wheel_size']);
        }

        if (isset($criteria['min_price'])) {
            $query->where('price', '>=', $criteria['min_price']);
        }

        if (isset($criteria['max_price'])) {
            $query->where('price', '<=', $criteria['max_price']);
        }

        if (isset($criteria['certified_only']) && $criteria['certified_only']) {
            $query->whereNotNull('certification_id');
        }

        if (isset($criteria['status'])) {
            $query->where('status', $criteria['status']);
        }

        if (isset($criteria['search'])) {
            $search = $criteria['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%");
            });
        }

        $eloquents = $query->get();

        return $eloquents->map(fn($eloquent) => $this->toDomain($eloquent));
    }

    public function delete(Product $product): void
    {
        if ($product->getId()) {
            EloquentProduct::destroy($product->getId());
        }
    }

    public function toDomainModel(EloquentProduct $eloquent): Product
    {
        return $this->toDomain($eloquent);
    }

    private function toDomain(EloquentProduct $eloquent): Product
    {
        $images = $eloquent->images->map(function ($image) {
            return ProductImage::create(
                $image->path,
                $image->is_primary,
                $image->order
            );
        });

        $product = new Product(
            id: $eloquent->id,
            sellerId: $eloquent->seller_id,
            title: Title::fromString($eloquent->title),
            description: $eloquent->description,
            price: Price::fromAmount($eloquent->price),
            bikeType: BikeType::fromString($eloquent->bike_type),
            frameMaterial: FrameMaterial::fromString($eloquent->frame_material),
            brakeType: BrakeType::fromString($eloquent->brake_type),
            wheelSize: WheelSize::fromString($eloquent->wheel_size),
            weight: $eloquent->weight ? Weight::fromValue($eloquent->weight, $eloquent->weight_unit ?? 'kg') : null,
            brand: $eloquent->brand ?? '',
            model: $eloquent->model ?? '',
            year: $eloquent->year,
            status: $eloquent->status ?? 'draft',
            categoryId: $eloquent->category_id,
            certificationId: $eloquent->certification_id,
            createdAt: $eloquent->created_at ? \DateTimeImmutable::createFromMutable($eloquent->created_at) : null,
            updatedAt: $eloquent->updated_at ? \DateTimeImmutable::createFromMutable($eloquent->updated_at) : null,
        );

        $product->setImages($images);

        return $product;
    }
}

