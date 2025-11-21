<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradeIn;
use App\Models\Credit;
use Illuminate\Http\Request;

class TradeInController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $query = TradeIn::with(['buyer', 'request', 'valuation']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('buyer', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $tradeIns = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.trade-ins.index', compact('tradeIns'));
    }

    public function show($id)
    {
        $tradeIn = TradeIn::with(['buyer', 'request', 'valuation'])->findOrFail($id);

        return view('admin.trade-ins.show', compact('tradeIn'));
    }

    public function approve(Request $request, $id)
    {
        $tradeIn = TradeIn::with(['valuation'])->findOrFail($id);

        if ($tradeIn->status !== 'valuated') {
            return redirect()->back()
                ->with('error', 'Only valuated trade-ins can be approved');
        }

        $validated = $request->validate([
            'credit_amount' => 'required|numeric|min:0',
        ]);

        // Update trade-in status
        $tradeIn->status = 'approved';
        $tradeIn->approved_at = now();
        $tradeIn->save();

        // Create credit for buyer
        Credit::create([
            'user_id' => $tradeIn->buyer_id,
            'trade_in_id' => $tradeIn->id,
            'amount' => $validated['credit_amount'],
            'balance' => $validated['credit_amount'],
            'status' => 'active',
            'expires_at' => now()->addYear(),
        ]);

        return redirect()->back()
            ->with('success', 'Trade-in approved and credit created successfully');
    }

    public function reject(Request $request, $id)
    {
        $tradeIn = TradeIn::findOrFail($id);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $tradeIn->status = 'rejected';
        $tradeIn->rejected_at = now();
        $tradeIn->rejection_reason = $validated['rejection_reason'];
        $tradeIn->save();

        return redirect()->back()
            ->with('success', 'Trade-in rejected successfully');
    }
}

