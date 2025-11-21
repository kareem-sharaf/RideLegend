<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Valuation extends Model
{
    protected $fillable = [
        'trade_in_id',
        'estimated_value',
        'final_value',
        'valuation_method',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'estimated_value' => 'decimal:2',
            'final_value' => 'decimal:2',
        ];
    }

    public function tradeIn(): BelongsTo
    {
        return $this->belongsTo(TradeIn::class);
    }
}
