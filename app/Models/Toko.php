<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Toko extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_toko',
        'nomor_wa',
        'kategori',
        'latitude',
        'longitude',
        'buka_jam',
        'tutup_jam',
        'informasi',
        'info_admin',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        // HAPUS CASTING INI - biarkan sebagai string
        // 'buka_jam' => 'datetime:H:i',
        // 'tutup_jam' => 'datetime:H:i',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function layanans(): HasMany
    {
        return $this->hasMany(Layanan::class);
    }

    public function scopeOpen($query)
    {
        $currentTime = now()->format('H:i:s');
        return $query->whereTime('buka_jam', '<=', $currentTime)
            ->whereTime('tutup_jam', '>=', $currentTime);
    }

    public function scopeActive($query)
    {
        return $query; // Tambahkan kondisi jika ada kolom status
    }

    public function getIsOpenAttribute(): bool
    {
        if (!$this->buka_jam || !$this->tutup_jam) {
            return false;
        }

        $currentTime = Carbon::now()->format('H:i');

        // Parse jam buka/tutup sebagai string
        $bukaJam = substr($this->buka_jam, 0, 5); // "08:00:00" -> "08:00"
        $tutupJam = substr($this->tutup_jam, 0, 5);

        // Handle case where closing time is next day
        if ($tutupJam < $bukaJam) {
            return $currentTime >= $bukaJam || $currentTime <= $tutupJam;
        }

        return $currentTime >= $bukaJam && $currentTime <= $tutupJam;
    }

    public function getStatusTextAttribute(): string
    {
        return $this->is_open ? 'Buka' : 'Tutup';
    }

    public function getFormattedWhatsappAttribute(): string
    {
        $number = preg_replace('/[^0-9]/', '', $this->nomor_wa ?? '');

        if (empty($number)) {
            return '6281234567890';
        }

        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        }

        if (substr($number, 0, 2) !== '62') {
            $number = '62' . $number;
        }

        return $number;
    }

    public function scopeHasLocation($query)
    {
        return $query->whereNotNull('latitude')
            ->whereNotNull('longitude');
    }

    public function scopePublic($query)
    {
        return $query->whereNotNull('latitude')
            ->whereNotNull('longitude');
    }

    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function calculateDistance($fromLat, $fromLng): float
    {
        if (!$this->latitude || !$this->longitude) {
            return 0;
        }

        $earthRadius = 6371;

        $latFrom = deg2rad($fromLat);
        $lonFrom = deg2rad($fromLng);
        $latTo = deg2rad($this->latitude);
        $lonTo = deg2rad($this->longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
