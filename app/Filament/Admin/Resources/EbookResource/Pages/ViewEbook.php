<?php

namespace App\Filament\Admin\Resources\EbookResource\Pages;

use App\Filament\Admin\Resources\EbookResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEbook extends ViewRecord
{
    protected static string $resource = EbookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
