<?php

namespace App\Filament\Admin\Resources\ArtikelResource\Pages;

use App\Filament\Admin\Resources\ArtikelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListArtikels extends ListRecords
{
    protected static string $resource = ArtikelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Artikel';
    }
}
