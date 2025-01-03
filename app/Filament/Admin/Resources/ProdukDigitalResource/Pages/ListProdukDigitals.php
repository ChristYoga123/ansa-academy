<?php

namespace App\Filament\Admin\Resources\ProdukDigitalResource\Pages;

use App\Filament\Admin\Resources\ProdukDigitalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListProdukDigitals extends ListRecords
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
