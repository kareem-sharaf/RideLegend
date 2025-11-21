<?php

namespace App\Http\Controllers;

use App\Application\Order\Actions\CancelOrderAction;
use App\Application\Order\Actions\GetUserOrdersAction;
use App\Application\Order\Actions\UpdateOrderStatusAction;
use App\Application\Order\DTOs\CancelOrderDTO;
use App\Application\Order\DTOs\GetUserOrdersDTO;
use App\Application\Order\DTOs\UpdateOrderStatusDTO;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private GetUserOrdersAction $getUserOrdersAction,
        private CancelOrderAction $cancelOrderAction,
        private UpdateOrderStatusAction $updateOrderStatusAction,
        private OrderRepositoryInterface $orderRepository,
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request): View|JsonResponse
    {
        $dto = new GetUserOrdersDTO(
            userId: $request->user()->id,
            status: $request->input('status'),
            page: $request->input('page', 1),
            perPage: $request->input('per_page', 15),
        );

        $orders = $this->getUserOrdersAction->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
                'orders' => $orders,
            ]);
        }

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Request $request, int $id): View|JsonResponse
    {
        $order = $this->orderRepository->findById($id);

        if (!$order) {
            abort(404);
        }

        if ($order->getBuyerId() !== $request->user()->id) {
            abort(403);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'order' => $order,
            ]);
        }

        return view('orders.show', [
            'order' => $order,
        ]);
    }

    public function cancel(Request $request, int $id): JsonResponse
    {
        $dto = new CancelOrderDTO(
            orderId: $id,
            userId: $request->user()->id,
        );

        $this->cancelOrderAction->execute($dto);

        return response()->json([
            'message' => 'Order cancelled successfully',
        ]);
    }
}

