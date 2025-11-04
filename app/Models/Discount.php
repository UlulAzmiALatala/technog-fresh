<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'amount',
        'expires_at',
        'is_active',
        'max_uses',     // <-- TAMBAHKAN INI
        'current_uses', // <-- TAMBAKAN INI
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'max_uses' => 'integer',     // <-- TAMBAHAN BAGUS
        'current_uses' => 'integer', // <-- TAMBAHAN BAGUS
    ];
}
