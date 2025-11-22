<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\TradeIns\Actions\ApproveTradeInAction;
use App\Application\Admin\TradeIns\Actions\EvaluateTradeInAction;
use App\Application\Admin\TradeIns\Actions\ListTradeInsAction;
use App\Application\Admin\TradeIns\Actions\RejectTradeInAction;
use App\Application\Admin\TradeIns\Actions\ShowTradeInAction;
use App\Application\Admin\TradeIns\DTOs\ApproveTradeInDTO;
use App\Application\Admin\TradeIns\DTOs\EvaluateTradeInDTO;
use App\Application\Admin\TradeIns\DTOs\ListTradeInsDTO;
use App\Application\Admin\TradeIns\DTOs\RejectTradeInDTO;
use App\Application\Admin\TradeIns\DTOs\ShowTradeInDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TradeInController extends Controller
{
    public function __construct(
        private ListTradeInsAction $listTradeInsAction,
        private ShowTradeInAction $showTradeInAction,
        private EvaluateTradeInAction $evaluateTradeInAction,
        private ApproveTradeInAction $approveTradeInAction,
        private RejectTradeInAction $rejectTradeInAction,
    ) {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $dto = new ListTradeInsDTO(
            status: $request->input('status'),
            search: $request->input('search'),
            buyerId: $request->input('buyer_id') ? (int)$request->input('buyer_id') : null,
            dateFrom: $request->input('date_from'),
            dateTo: $request->input('date_to'),
            sortBy: $request->input('sort_by', 'created_at'),
            sortDirection: $request->input('sort_direction', 'desc'),
            page: $request->input('page', 1),
            perPage: $request->input('per_page', 15),
        );

        $tradeIns = $this->listTradeInsAction->execute($dto);

        return view('admin.trade-ins.index', compact('tradeIns'));
    }

    public function show($id)
    {
        $dto = new ShowTradeInDTO(tradeInId: (int)$id);
        $tradeIn = $this->showTradeInAction->execute($dto);

        // Get Eloquent model for view
        $eloquentTradeIn = \App\Models\TradeIn::with(['buyer', 'request', 'valuation'])
            ->findOrFail($id);

        return view('admin.trade-ins.show', [
            'tradeIn' => $eloquentTradeIn,
            'domainTradeIn' => $tradeIn,
        ]);
    }

    public function evaluate(Request $request, $id)
    {
        $validated = $request->validate([
            'valuation_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $dto = new EvaluateTradeInDTO(
            tradeInId: (int)$id,
            valuationAmount: (float)$validated['valuation_amount'],
            notes: $validated['notes'] ?? null,
        );

        $this->evaluateTradeInAction->execute($dto);

        return redirect()->back()
            ->with('success', 'Trade-in evaluated successfully');
    }

    public function approve($id)
    {
        $dto = new ApproveTradeInDTO(tradeInId: (int)$id);
        $this->approveTradeInAction->execute($dto);

        return redirect()->back()
            ->with('success', 'Trade-in approved successfully');
    }

    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $dto = new RejectTradeInDTO(
            tradeInId: (int)$id,
            reason: $validated['reason'],
        );

        $this->rejectTradeInAction->execute($dto);

        return redirect()->back()
            ->with('success', 'Trade-in rejected successfully');
    }
}
