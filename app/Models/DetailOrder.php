<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailOrder extends Model
{
    use HasFactory;

    protected $table = 'detail_orders';

    protected $fillable = [
        'order_id',
        'service_id',
        'quantity',
        'price',
        'document_download'
    ];

    // Sebuah DetailOrder milik satu Order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Sebuah DetailOrder merujuk ke satu Service
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
