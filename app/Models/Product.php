<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'description',
        'price',
        'bike_type',
        'frame_material',
        'brake_type',
        'wheel_size',
        'weight',
        'weight_unit',
        'brand',
        'model',
        'year',
        'status',
        'category_id',
        'certification_id',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'weight' => 'decimal:2',
            'year' => 'integer',
        ];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function certification(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Certification::class, 'certification_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function inspection(): HasMany
    {
        return $this->hasMany(\App\Models\Inspection::class);
    }
}

