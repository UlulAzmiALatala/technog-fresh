<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'amount',
        'expires_at',
        'is_active',
        'max_uses',
        'current_uses',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'max_uses' => 'integer',
        'current_uses' => 'integer',
        'amount' => 'decimal:2',
    ];

    /**
     * MUTATOR: Membersihkan input angka (menghapus titik ribuan dan mengubah koma jadi titik).
     * Contoh: "1.500,50" -> "1500.50"
     */
    protected function setAmountAttribute($value)
    {
        if (is_string($value)) {
            // Hanya ganti koma ke titik (antisipasi input 40,70 menjadi 40.70)
            // JANGAN hapus titik di sini.
            $cleanAmount = str_replace(',', '.', $value);
            $this->attributes['amount'] = is_numeric($cleanAmount) ? (float) $cleanAmount : $value;
        } else {
            $this->attributes['amount'] = $value;
        }
    }
}
