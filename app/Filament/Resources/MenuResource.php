<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use App\Models\Toko;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Jualan Saya';
    protected static ?string $modelLabel = 'Menu';
    protected static ?string $pluralModelLabel = 'Menu';
    protected static ?int $navigationSort = 2;

    /**
     * Batasi query hanya untuk menu milik toko user login
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('toko', fn($q) => $q->where('user_id', Filament::auth()->id()));
    }

    /**
     * User tidak bisa membuat menu kalau belum punya toko
     */
    public static function canCreate(): bool
    {
        return Toko::where('user_id', Filament::auth()->id())->exists();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Hidden field untuk toko_id (otomatis ambil toko user login)
                Forms\Components\Hidden::make('toko_id')
                    ->default(fn() => Toko::where('user_id', Filament::auth()->id())->value('id'))
                    ->required(),

                Forms\Components\TextInput::make('nama_menu')
                    ->label('Nama Menu')
                    ->required()
                    ->maxLength(255),

            Forms\Components\TextInput::make('harga')
                ->label('Harga (Rp)')
                ->prefix('Rp')
                ->required()
                ->extraAttributes([
                    'x-data' => '{}',
                    'x-on:input' => "
            let value = \$el.value.replace(/[^0-9]/g, '');
            \$el.value = value ? new Intl.NumberFormat('id-ID').format(value) : '';
        ",
                ])
                ->dehydrateStateUsing(fn($state) => str_replace('.', '', $state)), // disimpan ke DB tanpa titik



            Forms\Components\FileUpload::make('foto')
                    ->label('Foto Menu')
                    ->directory('menus')
                    ->image()
                    ->imagePreviewHeight('120')
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),

                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->maxLength(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->square(),

                Tables\Columns\TextColumn::make('nama_menu')
                    ->label('Nama Menu')
                    ->searchable()
                    ->sortable(),

            Tables\Columns\TextColumn::make('harga')
                ->label('Harga')
                ->sortable()
                ->formatStateUsing(fn($state) => 'Rp' . number_format($state, 0, ',', '.')),


            Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(30),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Menu')
                    ->modalDescription('Apakah Anda yakin ingin menghapus menu ini?')
                    ->modalSubmitActionLabel('Ya, Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Belum ada menu')
            ->emptyStateDescription('Tambahkan menu pertama Anda untuk mulai berjualan.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Menu')
                    ->visible(fn() => static::canCreate()), // hanya tampil kalau user sudah punya toko
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
            // 'view' => Pages\ViewMenu::route('/{record}'),
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
