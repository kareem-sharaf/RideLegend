<?php

namespace App\Domain\Product\Models;

use App\Domain\Product\Events\ProductCreated;
use App\Domain\Product\Events\ProductUpdated;
use App\Domain\Product\ValueObjects\BikeType;
use App\Domain\Product\ValueObjects\BrakeType;
use App\Domain\Product\ValueObjects\FrameMaterial;
use App\Domain\Product\ValueObjects\Price;
use App\Domain\Product\ValueObjects\ProductImage;
use App\Domain\Product\ValueObjects\Title;
use App\Domain\Product\ValueObjects\Weight;
use App\Domain\Product\ValueObjects\WheelSize;
use App\Domain\Shared\Events\DomainEvent;
use Illuminate\Support\Collection;

class Product
{
    private Collection $domainEvents;
    private Collection $images;

    public function __construct(
        private ?int $id,
        private int $sellerId,
        private Title $title,
        private string $description,
        private Price $price,
        private BikeType $bikeType,
        private FrameMaterial $frameMaterial,
        private BrakeType $brakeType,
        private WheelSize $wheelSize,
        private ?Weight $weight = null,
        private string $brand = '',
        private string $model = '',
        private ?int $year = null,
        private string $status = 'draft',
        private ?int $categoryId = null,
        private ?int $certificationId = null,
        private ?\DateTimeImmutable $createdAt = null,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
        $this->domainEvents = new Collection();
        $this->images = new Collection();
    }

    public static function create(
        int $sellerId,
        Title $title,
        string $description,
        Price $price,
        BikeType $bikeType,
        FrameMaterial $frameMaterial,
        BrakeType $brakeType,
        WheelSize $wheelSize,
        ?Weight $weight = null,
        string $brand = '',
        string $model = '',
        ?int $year = null,
        ?int $categoryId = null
    ): self {
        $product = new self(
            id: null,
            sellerId: $sellerId,
            title: $title,
            description: $description,
            price: $price,
            bikeType: $bikeType,
            frameMaterial: $frameMaterial,
            brakeType: $brakeType,
            wheelSize: $wheelSize,
            weight: $weight,
            brand: $brand,
            model: $model,
            year: $year,
            status: 'draft',
            categoryId: $categoryId,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );

        $product->recordEvent(new ProductCreated($product));

        return $product;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSellerId(): int
    {
        return $this->sellerId;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getBikeType(): BikeType
    {
        return $this->bikeType;
    }

    public function getFrameMaterial(): FrameMaterial
    {
        return $this->frameMaterial;
    }

    public function getBrakeType(): BrakeType
    {
        return $this->brakeType;
    }

    public function getWheelSize(): WheelSize
    {
        return $this->wheelSize;
    }

    public function getWeight(): ?Weight
    {
        return $this->weight;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getCertificationId(): ?int
    {
        return $this->certificationId;
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function update(
        ?Title $title = null,
        ?string $description = null,
        ?Price $price = null,
        ?BikeType $bikeType = null,
        ?FrameMaterial $frameMaterial = null,
        ?BrakeType $brakeType = null,
        ?WheelSize $wheelSize = null,
        ?Weight $weight = null,
        ?string $brand = null,
        ?string $model = null,
        ?int $year = null,
        ?int $categoryId = null
    ): void {
        if ($title !== null) {
            $this->title = $title;
        }
        if ($description !== null) {
            $this->description = $description;
        }
        if ($price !== null) {
            $this->price = $price;
        }
        if ($bikeType !== null) {
            $this->bikeType = $bikeType;
        }
        if ($frameMaterial !== null) {
            $this->frameMaterial = $frameMaterial;
        }
        if ($brakeType !== null) {
            $this->brakeType = $brakeType;
        }
        if ($wheelSize !== null) {
            $this->wheelSize = $wheelSize;
        }
        if ($weight !== null) {
            $this->weight = $weight;
        }
        if ($brand !== null) {
            $this->brand = $brand;
        }
        if ($model !== null) {
            $this->model = $model;
        }
        if ($year !== null) {
            $this->year = $year;
        }
        if ($categoryId !== null) {
            $this->categoryId = $categoryId;
        }

        $this->updatedAt = new \DateTimeImmutable();
        $this->recordEvent(new ProductUpdated($this));
    }

    public function changeStatus(string $status): void
    {
        $allowedStatuses = ['draft', 'pending', 'active', 'sold', 'inactive'];
        if (!in_array($status, $allowedStatuses)) {
            throw new \DomainException("Invalid status: {$status}");
        }

        $this->status = $status;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function addImage(ProductImage $image): void
    {
        $this->images->push($image);
    }

    public function setImages(Collection $images): void
    {
        $this->images = $images;
    }

    public function assignCertification(int $certificationId): void
    {
        $this->certificationId = $certificationId;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function isCertified(): bool
    {
        return $this->certificationId !== null;
    }

    protected function recordEvent(DomainEvent $event): void
    {
        $this->domainEvents->push($event);
    }

    public function getDomainEvents(): Collection
    {
        return $this->domainEvents;
    }

    public function clearDomainEvents(): void
    {
        $this->domainEvents = new Collection();
    }
}

