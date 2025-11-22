<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\Settings\Actions\LoadSettingsAction;
use App\Application\Admin\Settings\Actions\UpdateSettingsAction;
use App\Application\Admin\Settings\DTOs\LoadSettingsDTO;
use App\Application\Admin\Settings\DTOs\UpdateSettingsDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct(
        private LoadSettingsAction $loadSettingsAction,
        private UpdateSettingsAction $updateSettingsAction,
    ) {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $dto = new LoadSettingsDTO();
        $settings = $this->loadSettingsAction->execute($dto);

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'seller_commission_rate' => 'nullable|numeric|min:0|max:100',
            'platform_fee' => 'nullable|numeric|min:0|max:100',
            'inspection_fee' => 'nullable|numeric|min:0',
            'shipping_base_cost' => 'nullable|numeric|min:0',
        ]);

        $dto = new UpdateSettingsDTO(
            commissionRate: $validated['commission_rate'] ?? null,
            sellerCommissionRate: $validated['seller_commission_rate'] ?? null,
            platformFee: $validated['platform_fee'] ?? null,
            inspectionFee: $validated['inspection_fee'] ?? null,
            shippingBaseCost: $validated['shipping_base_cost'] ?? null,
        );

        $this->updateSettingsAction->execute($dto);

        return redirect()->back()
            ->with('success', 'Settings updated successfully');
    }
}
