<?php

namespace App\Filament\Admin\Resources\ProdukDigitalResource\Pages;

use App\Filament\Admin\Resources\ProdukDigitalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProdukDigital extends ViewRecord
{
    protected static string $resource = ProdukDigitalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
