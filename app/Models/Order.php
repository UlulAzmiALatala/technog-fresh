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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the detail orders for the order.
     */
    public function detailOrders(): HasMany
    {
        return $this->hasMany(DetailOrder::class);
    }

    /**
     * Get the invoice associated with the order.
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * [TAMBAHAN] Relasi ke model Payment melalui Invoice
     * Memudahkan untuk menghitung total pembayaran
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Invoice::class);
    }
}
