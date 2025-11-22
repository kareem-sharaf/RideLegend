<?php

namespace App\Application\Admin\Settings\Actions;

use App\Application\Admin\Settings\DTOs\UpdateSettingsDTO;

class UpdateSettingsAction
{
    public function execute(UpdateSettingsDTO $dto): void
    {
        if ($dto->commissionRate !== null) {
            cache()->forever('settings.commission_rate', $dto->commissionRate);
        }

        if ($dto->sellerCommissionRate !== null) {
            cache()->forever('settings.seller_commission_rate', $dto->sellerCommissionRate);
        }

        if ($dto->platformFee !== null) {
            cache()->forever('settings.platform_fee', $dto->platformFee);
        }

        if ($dto->inspectionFee !== null) {
            cache()->forever('settings.inspection_fee', $dto->inspectionFee);
        }

        if ($dto->shippingBaseCost !== null) {
            cache()->forever('settings.shipping_base_cost', $dto->shippingBaseCost);
        }
    }
}

