<?php

namespace App\Application\Payment\Actions;

use App\Application\Payment\DTOs\ProcessPaymentDTO;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Domain\Payment\Models\Payment;
use App\Domain\Payment\Repositories\PaymentRepositoryInterface;
use App\Domain\Payment\ValueObjects\PaymentMethod;
use App\Domain\Product\ValueObjects\Price;
use App\Infrastructure\Services\Payments\PaymentServiceInterface;
use App\Infrastructure\Services\Payments\PaymentServiceFactory;
use Illuminate\Contracts\Events\Dispatcher;

class ProcessPaymentAction
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository,
        private OrderRepositoryInterface $orderRepository,
        private PaymentServiceFactory $paymentServiceFactory,
        private Dispatcher $eventDispatcher,
    ) {}

    public function execute(ProcessPaymentDTO $dto): Payment
    {
        // Validate order exists
        $order = $this->orderRepository->findById($dto->orderId);
        
        if (!$order) {
            throw new \DomainException('Order not found');
        }

        if ($order->getBuyerId() !== $dto->userId) {
            throw new \DomainException('Unauthorized: Order does not belong to user');
        }

        // Create payment domain model
        $paymentMethod = PaymentMethod::fromString($dto->paymentMethod);
        $amount = Price::fromAmount($dto->amount, $dto->currency);

        $payment = Payment::create(
            orderId: $dto->orderId,
            userId: $dto->userId,
            paymentMethod: $paymentMethod,
            amount: $amount,
            currency: $dto->currency
        );

        // Get appropriate payment service based on method
        $paymentService = $this->paymentServiceFactory->create($dto->paymentMethod);

        // Initialize payment with gateway
        $metadata = [
            'order_id' => $dto->orderId,
            'order_number' => $order->getOrderNumber()->getValue(),
            'user_id' => $dto->userId,
        ];

        try {
            $gatewayResponse = $paymentService->initializePayment(
                $dto->amount,
                $dto->currency,
                array_merge($metadata, $dto->paymentData ?? [])
            );

            $payment->markAsProcessing();
            $payment->complete(
                transactionId: $gatewayResponse['transaction_id'] ?? $gatewayResponse['id'] ?? 'pending',
                gatewayResponse: $gatewayResponse
            );
        } catch (\Exception $e) {
            $payment->fail($e->getMessage());
        }

        // Save payment
        $this->paymentRepository->save($payment);

        // Dispatch domain events
        foreach ($payment->getDomainEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }

        $payment->clearDomainEvents();

        return $payment;
    }
}

