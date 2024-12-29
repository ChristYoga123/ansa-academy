<?php

namespace App\Filament\Admin\Resources\KategoriMentoringResource\Pages;

use App\Filament\Admin\Resources\KategoriMentoringResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKategoriMentoring extends ViewRecord
{
    protected static string $resource = KategoriMentoringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
