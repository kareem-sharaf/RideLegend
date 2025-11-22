<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\Payments\Actions\ListPaymentsAction;
use App\Application\Admin\Payments\Actions\RefundPaymentAction;
use App\Application\Admin\Payments\Actions\ShowPaymentAction;
use App\Application\Admin\Payments\DTOs\ListPaymentsDTO;
use App\Application\Admin\Payments\DTOs\RefundPaymentDTO;
use App\Application\Admin\Payments\DTOs\ShowPaymentDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private ListPaymentsAction $listPaymentsAction,
        private ShowPaymentAction $showPaymentAction,
        private RefundPaymentAction $refundPaymentAction,
    ) {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $dto = new ListPaymentsDTO(
            status: $request->input('status'),
            paymentMethod: $request->input('payment_method'),
            search: $request->input('search'),
            userId: $request->input('user_id') ? (int)$request->input('user_id') : null,
            orderId: $request->input('order_id') ? (int)$request->input('order_id') : null,
            dateFrom: $request->input('date_from'),
            dateTo: $request->input('date_to'),
            minAmount: $request->input('min_amount') ? (float)$request->input('min_amount') : null,
            maxAmount: $request->input('max_amount') ? (float)$request->input('max_amount') : null,
            sortBy: $request->input('sort_by', 'created_at'),
            sortDirection: $request->input('sort_direction', 'desc'),
            page: $request->input('page', 1),
            perPage: $request->input('per_page', 15),
        );

        $payments = $this->listPaymentsAction->execute($dto);

        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $dto = new ShowPaymentDTO(paymentId: (int)$id);
        $payment = $this->showPaymentAction->execute($dto);

        // Get Eloquent model for view
        $eloquentPayment = \App\Models\Payment::with(['user', 'order'])->findOrFail($id);

        return view('admin.payments.show', [
            'payment' => $eloquentPayment,
            'domainPayment' => $payment,
        ]);
    }

    public function refund(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'nullable|numeric|min:0.01',
            'reason' => 'nullable|string|max:500',
        ]);

        $dto = new RefundPaymentDTO(
            paymentId: (int)$id,
            amount: $validated['amount'] ?? null,
            reason: $validated['reason'] ?? null,
        );

        try {
            $this->refundPaymentAction->execute($dto);
        } catch (\DomainException $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Payment refunded successfully');
    }
}
