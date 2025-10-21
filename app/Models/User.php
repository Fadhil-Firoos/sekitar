<?php
// app/Models/User.php
namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role', // admin | penjual
        'otp_code',
        'otp_expires_at',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Tentukan apakah user bisa mengakses panel tertentu
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Hanya user dengan role "admin" bisa masuk panel admin
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        // Hanya user dengan role "penjual" bisa masuk panel penjual
        if ($panel->getId() === 'penjual') {
            return $this->role === 'penjual';
        }

        // Default: semua user bisa akses panel lain
        return $this->is_verified;
    }

    /**
     * Helper role
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPenjual(): bool
    {
        return $this->role === 'penjual';
    }

    /**
     * Helper OTP
     */
    public function otpIsValid(string $otp): bool
    {
        return $this->otp_code === $otp && now()->lt($this->otp_expires_at);
    }

    public function markVerified(): void
    {
        $this->update([
            'is_verified' => true,
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);
    }

    /**
     * Relasi ke Toko (jika ada model Toko)
     */
    public function tokos()
    {
        return $this->hasMany(Toko::class);
    }

    public function toko()
    {
        return $this->hasOne(Toko::class);
    }

    public function hasToko(): bool
    {
        return $this->tokos()->exists();
    }

    public function getTokoNameAttribute(): ?string
    {
        return $this->toko?->nama_toko;
    }
}
