<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $query = Payment::with(['order', 'user']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('order', function($q) use ($search) {
                      $q->where('order_number', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with(['order', 'user'])->findOrFail($id);

        return view('admin.payments.show', compact('payment'));
    }

    public function refund(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        if ($payment->status !== 'completed') {
            return redirect()->back()
                ->with('error', 'Only completed payments can be refunded');
        }

        $validated = $request->validate([
            'amount' => 'nullable|numeric|min:0|max:' . $payment->amount,
            'reason' => 'nullable|string|max:500',
        ]);

        $refundAmount = $validated['amount'] ?? $payment->amount;

        // Update payment status
        $payment->status = 'refunded';
        $payment->save();

        // Here you would integrate with payment gateway to process refund
        // For now, we just update the status

        return redirect()->back()
            ->with('success', "Payment refunded successfully. Amount: $" . number_format($refundAmount, 2));
    }
}

