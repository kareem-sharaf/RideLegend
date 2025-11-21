<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeInRequest extends Model
{
    protected $fillable = [
        'trade_in_id',
        'bike_brand',
        'bike_model',
        'bike_year',
        'condition',
        'description',
        'images',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
        ];
    }

    public function tradeIn(): BelongsTo
    {
        return $this->belongsTo(TradeIn::class);
    }
}
