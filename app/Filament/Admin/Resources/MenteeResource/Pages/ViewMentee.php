<?php

namespace App\Filament\Admin\Resources\MenteeResource\Pages;

use App\Filament\Admin\Resources\MenteeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMentee extends ViewRecord
{
    protected static string $resource = MenteeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
