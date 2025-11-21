<?php

namespace App\Application\Payment\Actions;

use App\Application\Payment\DTOs\RefundPaymentDTO;
use App\Domain\Payment\Repositories\PaymentRepositoryInterface;
use App\Infrastructure\Services\Payments\PaymentServiceFactory;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\DB;

class RefundPaymentAction
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository,
        private PaymentServiceFactory $paymentServiceFactory,
        private Dispatcher $eventDispatcher,
    ) {}

    public function execute(RefundPaymentDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            $payment = $this->paymentRepository->findById($dto->paymentId);

            if (!$payment) {
                throw new \DomainException('Payment not found');
            }

            if (!$payment->getStatus()->isCompleted()) {
                throw new \DomainException('Only completed payments can be refunded');
            }

            if (!$payment->getTransactionId()) {
                throw new \DomainException('Payment transaction ID is missing');
            }

            // Get payment service
            $paymentService = $this->paymentServiceFactory->create(
                $payment->getPaymentMethod()->getValue()
            );

            // Process refund
            $refundAmount = $dto->amount ?? $payment->getAmount()->getAmount();
            
            $refundResponse = $paymentService->refundPayment(
                $payment->getTransactionId(),
                $refundAmount
            );

            if ($refundResponse['status'] === 'refunded' || $refundResponse['status'] === 'succeeded') {
                $payment->refund();
            } else {
                throw new \DomainException($refundResponse['message'] ?? 'Refund failed');
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

