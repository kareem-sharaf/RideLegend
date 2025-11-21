<?php

namespace App\Application\Checkout\Actions;

use App\Application\Checkout\DTOs\ProcessCheckoutDTO;
use App\Application\Order\Actions\CreateOrderAction;
use App\Application\Order\DTOs\CreateOrderDTO;
use App\Application\Payment\Actions\ProcessPaymentAction;
use App\Application\Payment\DTOs\ProcessPaymentDTO;
use App\Domain\Cart\Repositories\CartRepositoryInterface;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProcessCheckoutAction
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
        private ProductRepositoryInterface $productRepository,
        private CreateOrderAction $createOrderAction,
        private ProcessPaymentAction $processPaymentAction,
    ) {}

    public function execute(ProcessCheckoutDTO $dto): array
    {
        return DB::transaction(function () use ($dto) {
            // Validate cart has items
            $cartItems = $this->cartRepository->findByUserId($dto->userId);
            
            if (empty($cartItems)) {
                throw new \DomainException('Cart is empty');
            }

            // Validate all products are available and certified
            foreach ($cartItems as $cartItem) {
                $product = $this->productRepository->findById($cartItem->getProductId());
                
                if (!$product) {
                    throw new \DomainException("Product {$cartItem->getProductId()} not found");
                }

                if ($product->getStatus() !== 'active') {
                    throw new \DomainException("Product {$product->getId()} is not available");
                }

                // Optional: Check if product is certified
                // if (!$product->hasCertification()) {
                //     throw new \DomainException("Product {$product->getId()} is not certified");
                // }
            }

            // Calculate totals
            $calculateTotalsAction = new \App\Application\Checkout\Actions\CalculateCartTotalsAction(
                $this->cartRepository,
                $this->productRepository
            );

            $totals = $calculateTotalsAction->execute(
                new \App\Application\Checkout\DTOs\CalculateCartTotalsDTO(
                    userId: $dto->userId,
                    shippingCost: $dto->shippingCost,
                    discount: $dto->discount,
                    taxRate: $dto->taxRate,
                )
            );

            // Create order
            $orderDTO = new CreateOrderDTO(
                buyerId: $dto->userId,
                cartItems: $cartItems,
                subtotal: $totals['subtotal'],
                tax: $totals['tax'],
                shippingCost: $totals['shipping_cost'],
                discount: $totals['discount'],
                total: $totals['total'],
                shippingAddressLine1: $dto->shippingAddressLine1,
                shippingAddressLine2: $dto->shippingAddressLine2,
                shippingCity: $dto->shippingCity,
                shippingState: $dto->shippingState,
                shippingPostalCode: $dto->shippingPostalCode,
                shippingCountry: $dto->shippingCountry,
            );

            $order = $this->createOrderAction->execute($orderDTO);

            // Process payment if payment method is provided
            $payment = null;
            if ($dto->paymentMethod) {
                $paymentDTO = new ProcessPaymentDTO(
                    orderId: $order->getId(),
                    userId: $dto->userId,
                    paymentMethod: $dto->paymentMethod,
                    amount: $totals['total'],
                    paymentData: $dto->paymentData,
                );

                $payment = $this->processPaymentAction->execute($paymentDTO);
            }

            // Clear cart after successful checkout
            $this->cartRepository->clearUserCart($dto->userId);

            return [
                'order' => $order,
                'payment' => $payment,
            ];
        });
    }
}

