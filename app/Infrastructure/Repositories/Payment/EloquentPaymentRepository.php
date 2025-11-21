<?php

namespace App\Infrastructure\Repositories\Payment;

use App\Domain\Payment\Models\Payment;
use App\Domain\Payment\Repositories\PaymentRepositoryInterface;
use App\Domain\Payment\ValueObjects\PaymentMethod;
use App\Domain\Payment\ValueObjects\PaymentStatus;
use App\Domain\Product\ValueObjects\Price;
use App\Models\Payment as EloquentPayment;

class EloquentPaymentRepository implements PaymentRepositoryInterface
{
    public function save(Payment $payment): void
    {
        $eloquent = EloquentPayment::updateOrCreate(
            ['id' => $payment->getId()],
            [
                'order_id' => $payment->getOrderId(),
                'user_id' => $payment->getUserId(),
                'payment_method' => $payment->getPaymentMethod()->getValue(),
                'amount' => $payment->getAmount()->getAmount(),
                'currency' => $payment->getCurrency(),
                'status' => $payment->getStatus()->getValue(),
                'transaction_id' => $payment->getTransactionId(),
                'gateway_response' => $payment->getGatewayResponse(),
                'processed_at' => $payment->getProcessedAt(),
            ]
        );

        // Update payment ID in domain model if it was new
        if (!$payment->getId()) {
            $reflection = new \ReflectionClass($payment);
            $idProperty = $reflection->getProperty('id');
            $idProperty->setAccessible(true);
            $idProperty->setValue($payment, $eloquent->id);
        }
    }

    public function findById(int $id): ?Payment
    {
        $eloquent = EloquentPayment::find($id);

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findByOrderId(int $orderId): array
    {
        $eloquents = EloquentPayment::where('order_id', $orderId)->get();

        return $eloquents->map(fn($eloquent) => $this->toDomain($eloquent))->toArray();
    }

    public function findByTransactionId(string $transactionId): ?Payment
    {
        $eloquent = EloquentPayment::where('transaction_id', $transactionId)->first();

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    private function toDomain(EloquentPayment $eloquent): Payment
    {
        $paymentMethod = PaymentMethod::fromString($eloquent->payment_method);
        $status = PaymentStatus::fromString($eloquent->status);
        $amount = Price::fromAmount($eloquent->amount, $eloquent->currency);

        return new Payment(
            id: $eloquent->id,
            orderId: $eloquent->order_id,
            userId: $eloquent->user_id,
            paymentMethod: $paymentMethod,
            amount: $amount,
            currency: $eloquent->currency,
            status: $status,
            transactionId: $eloquent->transaction_id,
            gatewayResponse: $eloquent->gateway_response,
            processedAt: $eloquent->processed_at?->toImmutable(),
            createdAt: $eloquent->created_at?->toImmutable(),
            updatedAt: $eloquent->updated_at?->toImmutable(),
        );
    }
}

