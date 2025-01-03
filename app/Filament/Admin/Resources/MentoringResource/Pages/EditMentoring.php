<?php

namespace App\Filament\Admin\Resources\MentoringResource\Pages;

use App\Filament\Admin\Resources\MentoringResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMentoring extends EditRecord
{
    protected static string $resource = MentoringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
