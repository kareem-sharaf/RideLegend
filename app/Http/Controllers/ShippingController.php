<?php

namespace App\Http\Controllers;

use App\Application\Shipping\Actions\TrackShipmentAction;
use App\Application\Shipping\DTOs\TrackShipmentDTO;
use App\Domain\Shipping\Repositories\ShippingRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShippingController extends Controller
{
    public function __construct(
        private TrackShipmentAction $trackShipmentAction,
        private ShippingRepositoryInterface $shippingRepository,
    ) {
        $this->middleware('auth');
    }

    public function track(Request $request, string $trackingNumber): View|JsonResponse
    {
        $dto = new TrackShipmentDTO(trackingNumber: $trackingNumber);
        
        try {
            $result = $this->trackShipmentAction->execute($dto);
        } catch (\DomainException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 404);
            }
            abort(404, $e->getMessage());
        }

        if ($request->expectsJson()) {
            return response()->json([
                'shipping' => $result['shipping'],
                'tracking_info' => $result['tracking_info'],
            ]);
        }

        return view('shipping.track', [
            'shipping' => $result['shipping'],
            'trackingInfo' => $result['tracking_info'],
        ]);
    }

    public function show(Request $request, int $id): View|JsonResponse
    {
        $shipping = $this->shippingRepository->findById($id);

        if (!$shipping) {
            abort(404);
        }

        // TODO: Verify user has access to this shipping (through order)

        if ($request->expectsJson()) {
            return response()->json([
                'shipping' => $shipping,
            ]);
        }

        return view('shipping.show', [
            'shipping' => $shipping,
        ]);
    }
}

