<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inspection extends Model
{
    protected $fillable = [
        'product_id',
        'seller_id',
        'workshop_id',
        'status',
        'frame_grade',
        'frame_notes',
        'brake_grade',
        'brake_notes',
        'groupset_grade',
        'groupset_notes',
        'wheels_grade',
        'wheels_notes',
        'overall_grade',
        'notes',
        'requested_at',
        'scheduled_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'requested_at' => 'datetime',
            'scheduled_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(User::class, 'workshop_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(InspectionImage::class);
    }

    public function certification(): HasMany
    {
        return $this->hasMany(\App\Models\Certification::class);
    }
}

