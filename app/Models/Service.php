<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'project_type',
        'package_plan',
        'price',
        'estimated_duration',
        'duration_unit',
        'description',
        'use_case',
        'workflow',
        'features',
        'image',
    ];

    // Tambahkan baris ini agar Laravel mem-parsing JSON secara otomatis
    protected $casts = [
        'features' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function detailOrders(): HasMany
    {
        return $this->hasMany(DetailOrder::class);
    }
}
