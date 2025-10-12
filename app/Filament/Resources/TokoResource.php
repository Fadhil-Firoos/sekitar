<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TokoResource\Pages;
use App\Models\Toko;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\View;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;

class TokoResource extends Resource
{
    protected static ?string $model = Toko::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Toko Saya';
    protected static ?string $modelLabel = 'Toko';
    protected static ?string $pluralModelLabel = 'Toko';
    protected static ?int $navigationSort = 1;

    /**
     * Batasi query hanya untuk user yang login
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Filament::auth()->id());
    }

    /**
     * Cek apakah user dapat mengakses resource ini
     */
    public static function canAccess(): bool
    {
        return Filament::auth()->check();
    }

    /**
     * Batasi user hanya bisa create 1 toko
     */
    public static function canCreate(): bool
    {
        $userTokoCount = Toko::where('user_id', Filament::auth()->id())->count();
        return $userTokoCount === 0;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Hidden field untuk user_id
                Forms\Components\Hidden::make('user_id')
                    ->default(fn() => Filament::auth()->id())
                    ->required(),

                // Card untuk Informasi Toko
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('nama_toko')
                            ->label('Nama Usaha Anda')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('informasi')
                            ->label('Slogan Usaha')
                            ->maxLength(255),

                        Forms\Components\Select::make('kategori')
                            ->label('Kategori Usaha')
                            ->required()
                            ->options([
                                'makanan' => 'Makanan Tidak Keliling',
                                'minuman' => 'Minuman Tidak Keliling',
                                'makanan dan minuman' => 'Makanan dan Minuman Tidak Keliling',
                                'makanan keliling' => 'Makanan Keliling',
                                'minuman keliling' => 'Minuman Keliling',
                                'makanan dan minuman keliling' => 'Makanan dan Minuman Keliling',
                                
                            ])
                            ->searchable()
                            ->native(false),

                        Forms\Components\TextInput::make('nomor_wa')
                            ->label('No WhatsApp Usaha')
                            ->required()
                            ->maxLength(255)
                            ->tel()
                            ->helperText('Format: 08xxxxxxxxxx atau +62xxxxxxxxxx'),

                        Forms\Components\TimePicker::make('buka_jam')
                            ->label('Jam Buka')
                            ->required()
                            ->seconds(false)
                            ->minutesStep(60) // menit otomatis 00
                            ->default('07:00'),

                        Forms\Components\TimePicker::make('tutup_jam')
                            ->label('Jam Tutup')
                            ->required()
                            ->seconds(false)
                            ->minutesStep(60)
                            ->default('23:00'),
                    ])
                    ->columns(2),

                // Section Lokasi Toko
                Forms\Components\Section::make('Lokasi Usaha (akan mengikuti pergerakan Anda)')
                    ->schema([
                        Forms\Components\Hidden::make('latitude')
                            ->dehydrated(true),

                        Forms\Components\Hidden::make('longitude')
                            ->dehydrated(true),

                        View::make('forms.components.get-location-button'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_toko')
                    ->label('Nama Toko')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nomor_wa')
                    ->label('Nomor WhatsApp')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Nomor WhatsApp disalin'),

                Tables\Columns\TextColumn::make('buka_jam')
                    ->label('Jam Buka')
                    ->time('H:i'),

                Tables\Columns\TextColumn::make('tutup_jam')
                    ->label('Jam Tutup')
                    ->time('H:i'),

                Tables\Columns\IconColumn::make('is_open')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->getStateUsing(fn($record) => $record->is_open), // ✅ pakai accessor dari model

                Tables\Columns\TextColumn::make('menus_count')
                    ->label('Jumlah Menu')
                    ->counts('menus')
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_open')
                    ->label('Sedang Buka')
                    ->query(fn(Builder $query): Builder => $query->open()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Toko')
                    ->modalDescription('Apakah Anda yakin ingin menghapus toko ini? Semua menu yang terkait juga akan terhapus.')
                    ->modalSubmitActionLabel('Ya, Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Belum ada toko')
            ->emptyStateDescription('Buat toko pertama Anda untuk mulai berjualan.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Toko'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Tambahkan relasi jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTokos::route('/'),
            'create' => Pages\CreateToko::route('/create'),
            'view' => Pages\ViewToko::route('/{record}'),
            'edit' => Pages\EditToko::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('user_id', Filament::auth()->id())->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'primary';
    }
}