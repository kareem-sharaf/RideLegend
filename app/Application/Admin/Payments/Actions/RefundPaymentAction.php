<?php

namespace App\Application\Admin\Payments\Actions;

use App\Application\Admin\Payments\DTOs\RefundPaymentDTO;
use App\Application\Payment\Actions\RefundPaymentAction as PaymentRefundAction;
use App\Application\Payment\DTOs\RefundPaymentDTO as PaymentRefundDTO;

class RefundPaymentAction
{
    public function __construct(
        private PaymentRefundAction $paymentRefundAction,
    ) {}

    public function execute(RefundPaymentDTO $dto): void
    {
        $paymentRefundDTO = new PaymentRefundDTO(
            paymentId: $dto->paymentId,
            amount: $dto->amount,
            reason: $dto->reason,
        );

        $this->paymentRefundAction->execute($paymentRefundDTO);
    }
}

