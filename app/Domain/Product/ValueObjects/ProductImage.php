<?php

namespace App\Domain\Product\ValueObjects;

final class ProductImage
{
    public function __construct(
        private readonly string $path,
        private readonly bool $isPrimary = false,
        private readonly int $order = 0
    ) {}

    public static function create(string $path, bool $isPrimary = false, int $order = 0): self
    {
        return new self($path, $isPrimary, $order);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function isPrimary(): bool
    {
        return $this->isPrimary;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function markAsPrimary(): self
    {
        return new self($this->path, true, $this->order);
    }

    public function withOrder(int $order): self
    {
        return new self($this->path, $this->isPrimary, $order);
    }

    public function equals(ProductImage $other): bool
    {
        return $this->path === $other->path;
    }
}

