<?php

namespace App\Application\Checkout\Actions;

use App\Application\Checkout\DTOs\CalculateCartTotalsDTO;
use App\Domain\Cart\Repositories\CartRepositoryInterface;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\Price;

class CalculateCartTotalsAction
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function execute(CalculateCartTotalsDTO $dto): array
    {
        $cartItems = $this->cartRepository->findByUserId($dto->userId);

        if (empty($cartItems)) {
            return [
                'subtotal' => 0.0,
                'tax' => 0.0,
                'shipping_cost' => 0.0,
                'discount' => 0.0,
                'total' => 0.0,
            ];
        }

        // Calculate subtotal
        $subtotal = 0.0;
        foreach ($cartItems as $cartItem) {
            $product = $this->productRepository->findById($cartItem->getProductId());
            
            if (!$product || $product->getStatus() !== 'active') {
                continue; // Skip unavailable products
            }

            $unitPrice = $cartItem->getUnitPrice() 
                ? $cartItem->getUnitPrice()->getAmount() 
                : $product->getPrice()->getAmount();
            
            $subtotal += $unitPrice * $cartItem->getQuantity();
        }

        // Calculate shipping cost (if not provided, use default or calculate)
        $shippingCost = $dto->shippingCost ?? 0.0;

        // Calculate discount
        $discount = $dto->discount ?? 0.0;

        // Calculate tax
        $taxableAmount = $subtotal - $discount;
        $tax = $taxableAmount * ($dto->taxRate / 100);

        // Calculate total
        $total = $subtotal + $tax + $shippingCost - $discount;

        return [
            'subtotal' => round($subtotal, 2),
            'tax' => round($tax, 2),
            'shipping_cost' => round($shippingCost, 2),
            'discount' => round($discount, 2),
            'total' => round($total, 2),
        ];
    }
}

