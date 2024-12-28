<?php

namespace App\Filament\Admin\Resources\LokerMentorResource\Pages;

use App\Filament\Admin\Resources\LokerMentorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLokerMentors extends ListRecords
{
    protected static string $resource = LokerMentorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
