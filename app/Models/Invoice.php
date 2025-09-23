<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'invoice_number',
        'amount',
        'due_date',
        'status'
    ];

    // Sebuah Invoice milik satu Order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Sebuah Invoice bisa memiliki beberapa kali pembayaran (jika dicicil)
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
