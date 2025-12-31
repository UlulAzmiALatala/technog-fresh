<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'order_id', // Tambahkan ini
        'worker_id', // Tambahkan ini
        'description',
        'amount',
        'expense_date',
        'type',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Sebuah Expense dicatat oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Setiap Expense akan dicatat sebagai satu Transaction (Polymorphic).
     */
    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'reference');
    }
}
