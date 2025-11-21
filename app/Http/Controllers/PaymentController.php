<?php

namespace App\Http\Controllers;

use App\Application\Payment\Actions\ConfirmPaymentAction;
use App\Application\Payment\Actions\ProcessPaymentAction;
use App\Application\Payment\Actions\RefundPaymentAction;
use App\Application\Payment\DTOs\ConfirmPaymentDTO;
use App\Application\Payment\DTOs\ProcessPaymentDTO;
use App\Application\Payment\DTOs\RefundPaymentDTO;
use App\Domain\Payment\Repositories\PaymentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        private ProcessPaymentAction $processPaymentAction,
        private ConfirmPaymentAction $confirmPaymentAction,
        private RefundPaymentAction $refundPaymentAction,
        private PaymentRepositoryInterface $paymentRepository,
    ) {
        $this->middleware('auth');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'payment_method' => 'required|string|in:stripe,paypal,local_gateway,credit_card,bank_transfer',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'nullable|string|size:3',
            'payment_data' => 'nullable|array',
        ]);

        $dto = new ProcessPaymentDTO(
            orderId: $validated['order_id'],
            userId: $request->user()->id,
            paymentMethod: $validated['payment_method'],
            amount: $validated['amount'],
            currency: $validated['currency'] ?? 'USD',
            paymentData: $validated['payment_data'] ?? null,
        );

        $payment = $this->processPaymentAction->execute($dto);

        return response()->json([
            'message' => 'Payment processed',
            'payment' => $payment,
        ], 201);
    }

    public function confirm(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'transaction_id' => 'required|string',
            'gateway_response' => 'nullable|array',
        ]);

        $dto = new ConfirmPaymentDTO(
            paymentId: $id,
            transactionId: $validated['transaction_id'],
            gatewayResponse: $validated['gateway_response'] ?? null,
        );

        $this->confirmPaymentAction->execute($dto);

        return response()->json([
            'message' => 'Payment confirmed',
        ]);
    }

    public function refund(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'nullable|numeric|min:0.01',
            'reason' => 'nullable|string|max:500',
        ]);

        $dto = new RefundPaymentDTO(
            paymentId: $id,
            amount: $validated['amount'] ?? null,
            reason: $validated['reason'] ?? null,
        );

        $this->refundPaymentAction->execute($dto);

        return response()->json([
            'message' => 'Payment refunded',
        ]);
    }

    public function status(Request $request, int $id): View|JsonResponse
    {
        $payment = $this->paymentRepository->findById($id);

        if (!$payment) {
            abort(404);
        }

        if ($payment->getUserId() !== $request->user()->id) {
            abort(403);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'payment' => $payment,
            ]);
        }

        return view('payments.status', [
            'payment' => $payment,
        ]);
    }
}

