<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Tambahkan ini

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'type',
    ];

    /**
     * [BARU] Mendefinisikan relasi bahwa satu Kategori memiliki banyak Layanan.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
