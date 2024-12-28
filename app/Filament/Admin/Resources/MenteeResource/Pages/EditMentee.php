<?php

namespace App\Filament\Admin\Resources\MenteeResource\Pages;

use App\Filament\Admin\Resources\MenteeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMentee extends EditRecord
{
    protected static string $resource = MenteeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
