<?php

namespace App\Application\Payment\Actions;

use App\Application\Payment\DTOs\ConfirmPaymentDTO;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Domain\Payment\Repositories\PaymentRepositoryInterface;
use App\Infrastructure\Services\Payments\PaymentServiceFactory;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\DB;

class ConfirmPaymentAction
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository,
        private OrderRepositoryInterface $orderRepository,
        private PaymentServiceFactory $paymentServiceFactory,
        private Dispatcher $eventDispatcher,
    ) {}

    public function execute(ConfirmPaymentDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            $payment = $this->paymentRepository->findById($dto->paymentId);

            if (!$payment) {
                throw new \DomainException('Payment not found');
            }

            // Get payment service
            $paymentService = $this->paymentServiceFactory->create(
                $payment->getPaymentMethod()->getValue()
            );

            // Confirm payment with gateway
            $gatewayResponse = $paymentService->confirmPayment(
                $dto->transactionId,
                $dto->gatewayResponse ?? []
            );

            // Update payment status
            if ($gatewayResponse['status'] === 'completed' || $gatewayResponse['status'] === 'succeeded') {
                $payment->complete(
                    transactionId: $dto->transactionId,
                    gatewayResponse: $gatewayResponse
                );

                // Confirm order
                $order = $this->orderRepository->findById($payment->getOrderId());
                if ($order && $order->getStatus()->isPending()) {
                    $order->confirm();
                    $this->orderRepository->save($order);
                }
            } else {
                $payment->fail($gatewayResponse['message'] ?? 'Payment confirmation failed');
            }

            $this->paymentRepository->save($payment);

            // Dispatch domain events
            foreach ($payment->getDomainEvents() as $event) {
                $this->eventDispatcher->dispatch($event);
            }

            $payment->clearDomainEvents();
        });
    }
}

