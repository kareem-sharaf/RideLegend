<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $query = Inspection::with(['product', 'seller', 'workshop']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $inspections = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.inspections.index', compact('inspections'));
    }

    public function show($id)
    {
        $inspection = Inspection::with(['product', 'seller', 'workshop', 'images', 'certification'])
            ->findOrFail($id);

        return view('admin.inspections.show', compact('inspection'));
    }

    public function approve($id)
    {
        $inspection = Inspection::findOrFail($id);
        $inspection->status = 'approved';
        $inspection->save();

        return redirect()->back()
            ->with('success', 'Inspection approved successfully');
    }

    public function reject(Request $request, $id)
    {
        $inspection = Inspection::findOrFail($id);
        $inspection->status = 'rejected';
        $inspection->save();

        return redirect()->back()
            ->with('success', 'Inspection rejected successfully');
    }
}

