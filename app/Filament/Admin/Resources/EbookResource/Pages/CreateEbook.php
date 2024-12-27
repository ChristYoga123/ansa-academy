<?php

namespace App\Filament\Admin\Resources\EbookResource\Pages;

use App\Filament\Admin\Resources\EbookResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEbook extends CreateRecord
{
    protected static string $resource = EbookResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
