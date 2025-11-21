<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warranty;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $query = Warranty::with(['order', 'product']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $warranties = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.warranties.index', compact('warranties'));
    }

    public function show($id)
    {
        $warranty = Warranty::with(['order', 'product'])->findOrFail($id);

        return view('admin.warranties.show', compact('warranty'));
    }

    public function updateStatus(Request $request, $id)
    {
        $warranty = Warranty::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:active,expired,cancelled',
        ]);

        $warranty->status = $validated['status'];
        $warranty->save();

        return redirect()->back()
            ->with('success', 'Warranty status updated successfully');
    }
}

