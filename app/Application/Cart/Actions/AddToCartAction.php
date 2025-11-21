<?php

namespace App\Application\Cart\Actions;

use App\Application\Cart\DTOs\AddToCartDTO;
use App\Domain\Cart\Models\CartItem;
use App\Domain\Cart\Repositories\CartRepositoryInterface;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\Price;

class AddToCartAction
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function execute(AddToCartDTO $dto): CartItem
    {
        // Validate product exists and is available
        $product = $this->productRepository->findById($dto->productId);
        
        if (!$product) {
            throw new \DomainException('Product not found');
        }

        if ($product->getStatus() !== 'active') {
            throw new \DomainException('Product is not available for purchase');
        }

        // Check if item already exists in cart
        $existingCartItem = $this->cartRepository->findByUserAndProduct(
            $dto->userId,
            $dto->productId
        );

        if ($existingCartItem) {
            // Update quantity if item already exists
            $existingCartItem->incrementQuantity($dto->quantity);
            return $this->cartRepository->save($existingCartItem);
        }

        // Create new cart item
        $unitPrice = Price::fromAmount($product->getPrice()->getAmount());
        
        $cartItem = CartItem::create(
            userId: $dto->userId,
            productId: $dto->productId,
            quantity: $dto->quantity,
            unitPrice: $unitPrice
        );

        return $this->cartRepository->save($cartItem);
    }
}

