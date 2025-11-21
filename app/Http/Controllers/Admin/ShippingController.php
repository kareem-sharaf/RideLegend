<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $query = Shipping::with(['order']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by tracking number
        if ($request->filled('search')) {
            $query->where('tracking_number', 'like', "%{$request->search}%");
        }

        $shippings = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.shipping.index', compact('shippings'));
    }

    public function show($id)
    {
        $shipping = Shipping::with(['order', 'labels', 'trackingInfo'])->findOrFail($id);

        return view('admin.shipping.show', compact('shipping'));
    }

    public function updateStatus(Request $request, $id)
    {
        $shipping = Shipping::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,label_created,picked_up,in_transit,out_for_delivery,delivered,exception',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $shipping->status = $validated['status'];
        
        if (isset($validated['tracking_number'])) {
            $shipping->tracking_number = $validated['tracking_number'];
        }

        if ($validated['status'] === 'delivered') {
            $shipping->delivered_at = now();
        }

        $shipping->save();

        return redirect()->back()
            ->with('success', 'Shipping status updated successfully');
    }
}

