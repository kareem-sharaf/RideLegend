<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\Orders\Actions\CancelOrderAction;
use App\Application\Admin\Orders\Actions\ListOrdersAction;
use App\Application\Admin\Orders\Actions\ShowOrderAction;
use App\Application\Admin\Orders\Actions\UpdateOrderStatusAction;
use App\Application\Admin\Orders\DTOs\CancelOrderDTO;
use App\Application\Admin\Orders\DTOs\ListOrdersDTO;
use App\Application\Admin\Orders\DTOs\ShowOrderDTO;
use App\Application\Admin\Orders\DTOs\UpdateOrderStatusDTO;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class OrderController extends Controller
{
    public function __construct(
        private ListOrdersAction $listOrdersAction,
        private ShowOrderAction $showOrderAction,
        private UpdateOrderStatusAction $updateOrderStatusAction,
        private CancelOrderAction $cancelOrderAction,
    ) {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $dto = new ListOrdersDTO(
            status: $request->input('status'),
            search: $request->input('search'),
            buyerId: $request->input('buyer_id') ? (int)$request->input('buyer_id') : null,
            dateFrom: $request->input('date_from'),
            dateTo: $request->input('date_to'),
            minTotal: $request->input('min_total') ? (float)$request->input('min_total') : null,
            maxTotal: $request->input('max_total') ? (float)$request->input('max_total') : null,
            sortBy: $request->input('sort_by', 'created_at'),
            sortDirection: $request->input('sort_direction', 'desc'),
            page: $request->input('page', 1),
            perPage: $request->input('per_page', 15),
        );

        $orders = $this->listOrdersAction->execute($dto);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $dto = new ShowOrderDTO(orderId: (int)$id);
        $order = $this->showOrderAction->execute($dto);

        // Get Eloquent model for view
        $eloquentOrder = Order::with(['buyer', 'items.product', 'payments', 'shipping', 'warranties'])
            ->findOrFail($id);

        return view('admin.orders.show', [
            'order' => $eloquentOrder,
            'domainOrder' => $order,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded',
        ]);

        $dto = new UpdateOrderStatusDTO(
            orderId: (int)$id,
            status: $validated['status'],
        );

        $this->updateOrderStatusAction->execute($dto);

        return redirect()->back()
            ->with('success', 'Order status updated successfully');
    }

    public function invoice($id)
    {
        $order = Order::with(['buyer', 'items.product', 'payments'])
            ->findOrFail($id);

        $html = view('admin.orders.invoice', compact('order'))->render();
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $dompdf->stream('invoice-' . $order->order_number . '.pdf');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully');
    }
}
