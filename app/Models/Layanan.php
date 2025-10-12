<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'toko_id',
        'antar',
    ];

    /** Relasi ke Toko */
    public function toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class);
    }
}
