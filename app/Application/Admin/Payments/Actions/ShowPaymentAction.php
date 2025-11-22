<?php

namespace App\Application\Admin\Payments\Actions;

use App\Application\Admin\Payments\DTOs\ShowPaymentDTO;
use App\Domain\Payment\Repositories\PaymentRepositoryInterface;

class ShowPaymentAction
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository,
    ) {}

    public function execute(ShowPaymentDTO $dto)
    {
        $payment = $this->paymentRepository->findById($dto->paymentId);

        if (!$payment) {
            throw new \DomainException('Payment not found');
        }

        return $payment;
    }
}

