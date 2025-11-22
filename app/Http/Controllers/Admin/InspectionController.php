<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\Inspections\Actions\ApproveInspectionAction;
use App\Application\Admin\Inspections\Actions\ListInspectionsAction;
use App\Application\Admin\Inspections\Actions\RejectInspectionAction;
use App\Application\Admin\Inspections\Actions\ShowInspectionAction;
use App\Application\Admin\Inspections\DTOs\ApproveInspectionDTO;
use App\Application\Admin\Inspections\DTOs\ListInspectionsDTO;
use App\Application\Admin\Inspections\DTOs\RejectInspectionDTO;
use App\Application\Admin\Inspections\DTOs\ShowInspectionDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function __construct(
        private ListInspectionsAction $listInspectionsAction,
        private ShowInspectionAction $showInspectionAction,
        private ApproveInspectionAction $approveInspectionAction,
        private RejectInspectionAction $rejectInspectionAction,
    ) {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $dto = new ListInspectionsDTO(
            status: $request->input('status'),
            search: $request->input('search'),
            workshopId: $request->input('workshop_id') ? (int)$request->input('workshop_id') : null,
            productId: $request->input('product_id') ? (int)$request->input('product_id') : null,
            dateFrom: $request->input('date_from'),
            dateTo: $request->input('date_to'),
            sortBy: $request->input('sort_by', 'created_at'),
            sortDirection: $request->input('sort_direction', 'desc'),
            page: $request->input('page', 1),
            perPage: $request->input('per_page', 15),
        );

        $inspections = $this->listInspectionsAction->execute($dto);

        return view('admin.inspections.index', compact('inspections'));
    }

    public function show($id)
    {
        $dto = new ShowInspectionDTO(inspectionId: (int)$id);
        $inspection = $this->showInspectionAction->execute($dto);

        // Get Eloquent model for view
        $eloquentInspection = \App\Models\Inspection::with(['product', 'workshop', 'images'])
            ->findOrFail($id);

        return view('admin.inspections.show', [
            'inspection' => $eloquentInspection,
            'domainInspection' => $inspection,
        ]);
    }

    public function approve($id)
    {
        $dto = new ApproveInspectionDTO(inspectionId: (int)$id);
        $this->approveInspectionAction->execute($dto);

        return redirect()->back()
            ->with('success', 'Inspection approved successfully');
    }

    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $dto = new RejectInspectionDTO(
            inspectionId: (int)$id,
            reason: $validated['reason'],
        );

        $this->rejectInspectionAction->execute($dto);

        return redirect()->back()
            ->with('success', 'Inspection rejected successfully');
    }
}
