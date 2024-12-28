<?php

namespace App\Filament\Admin\Resources\LokerMentorResource\Pages;

use App\Filament\Admin\Resources\LokerMentorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLokerMentor extends EditRecord
{
    protected static string $resource = LokerMentorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
