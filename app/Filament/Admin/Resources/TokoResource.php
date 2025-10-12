<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TokoResource\Pages;
use App\Models\Toko;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class TokoResource extends Resource
{
    protected static ?string $model = Toko::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\TextInput::make('nama_toko')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_wa')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('buka_jam')
                    ->required(),
                Forms\Components\TextInput::make('tutup_jam')
                    ->required(),
                Forms\Components\TextInput::make('latitude')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('longitude')
                    ->numeric()
                    ->default(null),
                Forms\Components\Textarea::make('informasi')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('info_admin')
                    ->label('Informasi dari Admin')
                    ->placeholder('Pesan dari admin untuk pemilik toko...')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pemilik')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_toko')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_wa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('buka_jam'),
                Tables\Columns\TextColumn::make('tutup_jam'),
                Tables\Columns\TextColumn::make('info_admin')
                    ->label('Info Admin')
                    ->limit(40)
                    ->tooltip(fn($record) => $record->info_admin),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('kirim_info')
                    ->label('Kirim Info')
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->color('info')
                    ->form([
                        Forms\Components\Textarea::make('pesan')
                            ->label('Pesan Informasi')
                            ->required()
                            ->default("Usaha Anda akan tampil di Peta Sekitarmu sampai dengan 31 Desember 2026.Biaya Perpanjangan Rp 10.000 per 6 Bulan.Silahkan hubungi Admin 0812-1232-23232"),
                    ])
                    ->action(function (array $data, Toko $record): void {
                        $record->update([
                            'info_admin' => $data['pesan'],
                        ]);

                        Notification::make()
                            ->title('Pesan Terkirim')
                            ->body('Informasi berhasil dikirim ke toko: ' . $record->nama_toko)
                            ->success()
                            ->send();
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTokos::route('/'),
            'create' => Pages\CreateToko::route('/create'),
            'edit' => Pages\EditToko::route('/{record}/edit'),
        ];
    }
}
