<?php

namespace App\Filament\Admin\Resources\ProdukDigitalResource\Pages;

use App\Filament\Admin\Resources\ProdukDigitalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProdukDigital extends EditRecord
{
    protected static string $resource = ProdukDigitalResource::class;

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
