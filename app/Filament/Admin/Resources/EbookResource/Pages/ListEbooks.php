<?php

namespace App\Filament\Admin\Resources\EbookResource\Pages;

use App\Filament\Admin\Resources\EbookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListEbooks extends ListRecords
{
    protected static string $resource = EbookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Ebook';
    }
}
