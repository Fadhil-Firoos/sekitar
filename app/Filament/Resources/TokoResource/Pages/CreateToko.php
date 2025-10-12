<?php

namespace App\Filament\Resources\TokoResource\Pages;

use App\Filament\Resources\TokoResource;
use App\Filament\Resources\MenuResource; // tambahkan ini
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;

class CreateToko extends CreateRecord
{
    protected static string $resource = TokoResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Toko berhasil dibuat!';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Filament::auth()->id();
        return $data;
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Selamat! Toko Anda telah dibuat')
            ->body('Anda sekarang dapat menambahkan menu dan mulai menerima pesanan.')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return MenuResource::getUrl('index');
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getCreateFormAction(): Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Buat Toko')
            ->color('primary');
    }

    protected function getCancelFormAction(): Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }   
}