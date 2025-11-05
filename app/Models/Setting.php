<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $primaryKey = 'key'; // Gunakan 'key' sebagai Primary Key
    public $incrementing = false;  // Beritahu Laravel bahwa 'key' bukan auto-increment
    protected $keyType = 'string'; // Tipe datanya string

    protected $fillable = [
        'key',
        'value',
    ];
}
