<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipping extends Model
{
    protected $fillable = [
        'order_id',
        'carrier',
        'service_type',
        'status',
        'tracking_number',
        'cost',
        'shipped_at',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'cost' => 'decimal:2',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function labels(): HasMany
    {
        return $this->hasMany(ShippingLabel::class);
    }

    public function trackingInfo(): HasMany
    {
        return $this->hasMany(TrackingInfo::class);
    }
}
