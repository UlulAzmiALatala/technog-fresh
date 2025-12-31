<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'bank_name',            // Tambahkan ini
        'bank_account_number',  // Tambahkan ini
        'bank_account_name',    // Tambahkan ini
        'bank_info',            // Tetap simpan jika kolomnya masih ada di DB
        'specialization',
    ];

    /**
     * Seorang Worker bisa memiliki banyak catatan pengeluaran (payouts).
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'worker_id');
    }
}
