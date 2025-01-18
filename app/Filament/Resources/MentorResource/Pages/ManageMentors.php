<?php

namespace App\Filament\Resources\MentorResource\Pages;

use Filament\Actions;
use App\Filament\Resources\MentorResource;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Resources\Pages\ManageRecords;

class ManageMentors extends ManageRecords
{
    protected static string $resource = MentorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Mentor';
    }
}
