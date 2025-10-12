<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Toko;
use Illuminate\Support\Facades\Auth;

class InformasiAkun extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = 'Status Akun';
    protected static ?string $title = 'Status Akun';
    protected static string $view = 'filament.pages.informasi-akun';
    protected static ?int $navigationSort = 99;

    // Batasi agar hanya penjual yang bisa melihat
    public static function shouldRegisterNavigation(): bool
    {
        return Auth::check() && Auth::user()->role === 'penjual';
    }

    public function getToko()
    {
        return Toko::where('user_id', Auth::id())->first();
    }
}