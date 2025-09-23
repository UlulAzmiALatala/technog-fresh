<?php
// File: app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'amount',
        'payment_date',
        'method',
        'payment_proof'
    ];

    // Sebuah Payment milik satu Invoice
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    // Setiap Payment akan dicatat sebagai satu Transaction (Polymorphic)
    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'reference');
    }
}
