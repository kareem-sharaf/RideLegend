<?php

namespace App\Application\Admin\Settings\Actions;

use App\Application\Admin\Settings\DTOs\LoadSettingsDTO;
use App\Infrastructure\Cache\CacheService;

class LoadSettingsAction
{
    public function __construct(
        private CacheService $cacheService,
    ) {}

    public function execute(LoadSettingsDTO $dto): array
    {
        return [
            'commission_rate' => cache()->get('settings.commission_rate', 10.0),
            'seller_commission_rate' => cache()->get('settings.seller_commission_rate', 8.0),
            'platform_fee' => cache()->get('settings.platform_fee', 2.0),
            'inspection_fee' => cache()->get('settings.inspection_fee', 50.0),
            'shipping_base_cost' => cache()->get('settings.shipping_base_cost', 15.0),
        ];
    }
}

