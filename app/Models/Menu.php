<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'toko_id',
        'nama_menu',
        'harga',
        'foto',
        'deskripsi', // kolom foto simpan di database (BLOB atau base64)
    ];

    /**
     * Relasi ke Toko
     */
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    /**
     * Harga format Rp
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Foto langsung dari database
     * Bisa tampil di <img src="{{ $menu->foto_base64 }}">
     */
    public function getFotoBase64Attribute()
    {
        if (!$this->foto) {
            // fallback jika tidak ada foto
            return asset('images/default-menu.png');
        }

        // Jika kolom foto berupa binary (BLOB) → encode
        if (!preg_match('/^data:image/', $this->foto)) {
            return 'data:image/jpeg;base64,' . base64_encode($this->foto);
        }

        // Jika kolom sudah disimpan dalam bentuk base64
        return $this->foto;
    }
}
