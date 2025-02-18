<?php

namespace App\Filament\Admin\Resources\ProdukDigitalResource\Pages;

use App\Filament\Admin\Resources\ProdukDigitalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Support\Htmlable;

class ManageProdukDigitals extends ManageRecords
{
    protected static string $resource = ProdukDigitalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->closeModalByClickingAway(false),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Produk Digital';
    }
}
