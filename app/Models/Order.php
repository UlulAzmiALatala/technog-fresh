<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_date',
        'total_price',
        'status',
        'snap_token',
        'notes',
        'payment_type',
        'dp_amount',
        'progress',
        'due_date',
        'delivery_option',
        'discount_code',
        'discount_amount',
        'negotiated_price_fast',
        'negotiated_price_express',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'order_date' => 'datetime',
        // PERBAIKAN: Cast keuangan ke decimal agar mendukung koma
        'total_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'dp_amount' => 'decimal:2',
        'negotiated_price_fast' => 'decimal:2',
        'negotiated_price_express' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function detailOrders(): HasMany
    {
        return $this->hasMany(DetailOrder::class);
    }
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Invoice::class);
    }
    public function testimonial(): HasOne
    {
        return $this->hasOne(Testimonial::class);
    }
    public function expenses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
