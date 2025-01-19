<?php

namespace App\Filament\Resources\LokerMentorResource\Pages;

use Filament\Actions;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\LokerMentorResource;

class ManageLokerMentors extends ManageRecords
{
    protected static string $resource = LokerMentorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Loker Mentor';
    }
}
