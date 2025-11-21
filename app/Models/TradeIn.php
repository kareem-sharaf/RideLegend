<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TradeIn extends Model
{
    protected $fillable = [
        'buyer_id',
        'status',
        'requested_at',
        'approved_at',
        'rejected_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'requested_at' => 'datetime',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function request(): HasOne
    {
        return $this->hasOne(TradeInRequest::class);
    }

    public function valuation(): HasOne
    {
        return $this->hasOne(Valuation::class);
    }
}
