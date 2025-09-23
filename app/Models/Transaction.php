<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'description',
        'reference_id',
        'reference_type'
    ];

    // Sebuah Transaksi dicatat oleh satu User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Polymorphic: bisa merujuk ke model Payment atau Expense
    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}
