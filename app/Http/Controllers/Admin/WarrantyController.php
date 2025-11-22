<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\Warranties\Actions\ListWarrantiesAction;
use App\Application\Admin\Warranties\Actions\ShowWarrantyAction;
use App\Application\Admin\Warranties\Actions\UpdateWarrantyAction;
use App\Application\Admin\Warranties\DTOs\ListWarrantiesDTO;
use App\Application\Admin\Warranties\DTOs\ShowWarrantyDTO;
use App\Application\Admin\Warranties\DTOs\UpdateWarrantyDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    public function __construct(
        private ListWarrantiesAction $listWarrantiesAction,
        private ShowWarrantyAction $showWarrantyAction,
        private UpdateWarrantyAction $updateWarrantyAction,
    ) {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $dto = new ListWarrantiesDTO(
            status: $request->input('status'),
            type: $request->input('type'),
            search: $request->input('search'),
            orderId: $request->input('order_id') ? (int)$request->input('order_id') : null,
            productId: $request->input('product_id') ? (int)$request->input('product_id') : null,
            dateFrom: $request->input('date_from'),
            dateTo: $request->input('date_to'),
            sortBy: $request->input('sort_by', 'created_at'),
            sortDirection: $request->input('sort_direction', 'desc'),
            page: $request->input('page', 1),
            perPage: $request->input('per_page', 15),
        );

        $warranties = $this->listWarrantiesAction->execute($dto);

        return view('admin.warranties.index', compact('warranties'));
    }

    public function show($id)
    {
        $dto = new ShowWarrantyDTO(warrantyId: (int)$id);
        $warranty = $this->showWarrantyAction->execute($dto);

        // Get Eloquent model for view
        $eloquentWarranty = \App\Models\Warranty::with(['order', 'product'])->findOrFail($id);

        return view('admin.warranties.show', [
            'warranty' => $eloquentWarranty,
            'domainWarranty' => $warranty,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,expired,cancelled',
        ]);

        $dto = new UpdateWarrantyDTO(
            warrantyId: (int)$id,
            status: $validated['status'],
        );

        $this->updateWarrantyAction->execute($dto);

        return redirect()->back()
            ->with('success', 'Warranty status updated successfully');
    }
}
