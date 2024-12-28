<?php

namespace App\Filament\Admin\Resources\LokerMentorResource\Pages;

use App\Filament\Admin\Resources\LokerMentorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLokerMentor extends ViewRecord
{
    protected static string $resource = LokerMentorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
