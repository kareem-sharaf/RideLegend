<?php

namespace App\Http\Controllers;

use App\Application\TradeIn\Actions\SubmitTradeInRequestAction;
use App\Application\TradeIn\DTOs\SubmitTradeInRequestDTO;
use App\Domain\TradeIn\Repositories\TradeInRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TradeInController extends Controller
{
    public function __construct(
        private SubmitTradeInRequestAction $submitTradeInRequestAction,
        private TradeInRepositoryInterface $tradeInRepository,
    ) {
        $this->middleware('auth');
    }

    public function create(Request $request): View
    {
        return view('trade-in.form');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'condition' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $dto = new SubmitTradeInRequestDTO(
            buyerId: $request->user()->id,
            brand: $validated['brand'],
            model: $validated['model'],
            year: $validated['year'] ?? null,
            condition: $validated['condition'] ?? null,
            description: $validated['description'] ?? null,
            images: $validated['images'] ?? null,
        );

        $tradeIn = $this->submitTradeInRequestAction->execute($dto);

        return response()->json([
            'message' => 'Trade-in request submitted',
            'trade_in' => $tradeIn,
        ], 201);
    }

    public function index(Request $request): View|JsonResponse
    {
        $tradeIns = $this->tradeInRepository->findByBuyerId($request->user()->id);

        if ($request->expectsJson()) {
            return response()->json([
                'trade_ins' => $tradeIns,
            ]);
        }

        return view('trade-in.index', [
            'tradeIns' => $tradeIns,
        ]);
    }

    public function show(Request $request, int $id): View|JsonResponse
    {
        $tradeIn = $this->tradeInRepository->findById($id);

        if (!$tradeIn) {
            abort(404);
        }

        if ($tradeIn->getBuyerId() !== $request->user()->id) {
            abort(403);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'trade_in' => $tradeIn,
            ]);
        }

        return view('trade-in.show', [
            'tradeIn' => $tradeIn,
        ]);
    }
}

