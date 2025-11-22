<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\Shipping\Actions\ListShippingRecordsAction;
use App\Application\Admin\Shipping\Actions\ShowShippingRecordAction;
use App\Application\Admin\Shipping\Actions\UpdateShippingStatusAction;
use App\Application\Admin\Shipping\DTOs\ListShippingRecordsDTO;
use App\Application\Admin\Shipping\DTOs\ShowShippingRecordDTO;
use App\Application\Admin\Shipping\DTOs\UpdateShippingStatusDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function __construct(
        private ListShippingRecordsAction $listShippingRecordsAction,
        private ShowShippingRecordAction $showShippingRecordAction,
        private UpdateShippingStatusAction $updateShippingStatusAction,
    ) {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $dto = new ListShippingRecordsDTO(
            status: $request->input('status'),
            carrier: $request->input('carrier'),
            search: $request->input('search'),
            orderId: $request->input('order_id') ? (int)$request->input('order_id') : null,
            dateFrom: $request->input('date_from'),
            dateTo: $request->input('date_to'),
            sortBy: $request->input('sort_by', 'created_at'),
            sortDirection: $request->input('sort_direction', 'desc'),
            page: $request->input('page', 1),
            perPage: $request->input('per_page', 15),
        );

        $shippings = $this->listShippingRecordsAction->execute($dto);

        return view('admin.shipping.index', compact('shippings'));
    }

    public function show($id)
    {
        $dto = new ShowShippingRecordDTO(shippingId: (int)$id);
        $shipping = $this->showShippingRecordAction->execute($dto);

        // Get Eloquent model for view
        $eloquentShipping = \App\Models\Shipping::with(['order', 'labels', 'trackingInfo'])
            ->findOrFail($id);

        return view('admin.shipping.show', [
            'shipping' => $eloquentShipping,
            'domainShipping' => $shipping,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,label_created,picked_up,in_transit,out_for_delivery,delivered,exception',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $dto = new UpdateShippingStatusDTO(
            shippingId: (int)$id,
            status: $validated['status'],
            trackingNumber: $validated['tracking_number'] ?? null,
        );

        $this->updateShippingStatusAction->execute($dto);

        return redirect()->back()
            ->with('success', 'Shipping status updated successfully');
    }
}
