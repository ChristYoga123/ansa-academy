<?php

namespace App\Filament\Admin\Resources\LombaResource\Pages;

use App\Filament\Admin\Resources\LombaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLomba extends EditRecord
{
    protected static string $resource = LombaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
