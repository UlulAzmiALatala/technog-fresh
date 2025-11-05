<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // Import Storage facade

class Logo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot logic untuk menghapus file saat model dihapus.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($logo) {
            // Hapus file dari storage saat data di database dihapus
            if ($logo->path) {
                Storage::disk('public')->delete($logo->path);
            }
        });
    }
}
