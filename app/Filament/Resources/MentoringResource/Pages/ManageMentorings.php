<?php

namespace App\Filament\Resources\MentoringResource\Pages;

use App\Filament\Resources\MentoringResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMentorings extends ManageRecords
{
    protected static string $resource = MentoringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}