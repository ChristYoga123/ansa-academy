<?php

namespace App\Filament\Admin\Resources\LombaResource\Pages;

use App\Filament\Admin\Resources\LombaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLomba extends CreateRecord
{
    protected static string $resource = LombaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
