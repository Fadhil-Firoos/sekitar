<?php

namespace App\Filament\Resources\TokoResource\Pages;

use App\Filament\Resources\TokoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Facades\Filament;

class ViewToko extends ViewRecord
{
    protected static string $resource = TokoResource::class;

    /**
     * Authorize user can only view their own toko
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
            Actions\EditAction::make(),
        ];
    }
}
