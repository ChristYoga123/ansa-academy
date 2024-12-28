<?php

namespace App\Filament\Admin\Resources\LombaResource\Pages;

use App\Filament\Admin\Resources\LombaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLomba extends ViewRecord
{
    protected static string $resource = LombaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
