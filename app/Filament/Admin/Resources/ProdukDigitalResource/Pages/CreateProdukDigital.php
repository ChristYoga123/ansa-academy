<?php

namespace App\Filament\Admin\Resources\ProdukDigitalResource\Pages;

use App\Filament\Admin\Resources\ProdukDigitalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProdukDigital extends CreateRecord
{
    protected static string $resource = ProdukDigitalResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
