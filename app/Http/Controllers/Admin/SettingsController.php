<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $settings = [
            'commission_rate' => Cache::get('settings.commission_rate', 10.0),
            'seller_commission_rate' => Cache::get('settings.seller_commission_rate', 5.0),
            'platform_fee' => Cache::get('settings.platform_fee', 2.5),
            'inspection_fee' => Cache::get('settings.inspection_fee', 50.0),
            'shipping_base_cost' => Cache::get('settings.shipping_base_cost', 15.0),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'commission_rate' => 'required|numeric|min:0|max:100',
            'seller_commission_rate' => 'required|numeric|min:0|max:100',
            'platform_fee' => 'required|numeric|min:0|max:100',
            'inspection_fee' => 'required|numeric|min:0',
            'shipping_base_cost' => 'required|numeric|min:0',
        ]);

        // Store in cache (in production, use database or config file)
        foreach ($validated as $key => $value) {
            Cache::forever("settings.{$key}", $value);
        }

        return redirect()->back()
            ->with('success', 'Settings updated successfully');
    }
}

