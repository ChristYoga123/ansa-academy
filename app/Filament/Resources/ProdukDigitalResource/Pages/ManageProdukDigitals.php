<?php

namespace App\Filament\Resources\ProdukDigitalResource\Pages;

use App\Filament\Resources\ProdukDigitalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Support\Htmlable;

class ManageProdukDigitals extends ManageRecords
{
    protected static string $resource = ProdukDigitalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Produk Digital';
    }
}
