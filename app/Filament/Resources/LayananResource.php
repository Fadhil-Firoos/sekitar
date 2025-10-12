<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LayananResource\Pages;
use App\Models\Layanan;
use App\Models\Toko;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;

class LayananResource extends Resource
{
    protected static ?string $model = Layanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Layanan';
    protected static ?string $modelLabel = 'Layanan';
    protected static ?string $pluralModelLabel = 'Layanan';
    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('toko', fn($q) => $q->where('user_id', Filament::auth()->id()));
    }

    /**
     * Hanya izinkan buat layanan jika:
     * - user sudah punya toko
     * - toko tersebut belum punya layanan
     */
    public static function canCreate(): bool
    {
        $tokoId = Toko::where('user_id', Filament::auth()->id())->value('id');
        if (!$tokoId) {
            return false; // user belum punya toko
        }

        $layananCount = Layanan::where('toko_id', $tokoId)->count();
        return $layananCount === 0; // hanya bisa sekali
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('toko_id')
                    ->default(fn() => Toko::where('user_id', Filament::auth()->id())->value('id'))
                    ->required(),

                Forms\Components\Textarea::make('antar')
                    ->label('Layanan Antar')
                    ->rows(3)
                    ->placeholder('Contoh: Metro, Lampung Tengah, Lampung Timur')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('toko.nama_toko')
                    ->label('Toko')
                    ->sortable(),

                Tables\Columns\TextColumn::make('antar')
                    ->label('Daerah Antar')
                    ->limit(50),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
            ])
            ->emptyStateHeading('Belum ada layanan')
            ->emptyStateDescription('Tambahkan layanan antar untuk toko Anda.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Layanan')
                    ->visible(fn() => static::canCreate()), // tombol create hilang kalau sudah ada layanan
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLayanans::route('/'),
            'create' => Pages\CreateLayanan::route('/create'),
            'edit' => Pages\EditLayanan::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereHas('toko', fn($q) => $q->where('user_id', Filament::auth()->id()))->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'primary';
    }
}
