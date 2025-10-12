<?php

namespace App\Filament\Resources\TokoResource\Pages;

use App\Filament\Resources\TokoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

class EditToko extends EditRecord
{
    protected static string $resource = TokoResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    /**
     * Authorize user can only edit their own toko
     */
    protected function authorizeAccess(): void
    {
        $user = Filament::auth()->user();

        if ($this->getRecord()->user_id !== $user->id) {
            $this->redirect(static::getResource()::getUrl('index'));
            return;
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Hapus Toko')
                ->modalDescription('Apakah Anda yakin ingin menghapus toko ini? Tindakan ini tidak dapat dibatalkan.')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Toko berhasil diperbarui!';
    }

    /**
     * Mutate form data sebelum save untuk memastikan user_id tidak berubah
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Pastikan user_id tidak berubah
        $data['user_id'] = Filament::auth()->id();
        return $data;
    }

    /**
     * Customize save button
     */
    protected function getSaveFormAction(): Actions\Action
    {
        return parent::getSaveFormAction()
            ->label('Simpan Perubahan');
    }

    /**
     * Customize cancel button
     */
    protected function getCancelFormAction(): Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }
}
