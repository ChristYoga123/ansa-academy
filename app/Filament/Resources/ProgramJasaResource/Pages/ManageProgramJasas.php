<?php

namespace App\Filament\Resources\ProgramJasaResource\Pages;

use App\Filament\Resources\ProgramJasaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Support\Htmlable;

class ManageProgramJasas extends ManageRecords
{
    protected static string $resource = ProgramJasaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Jasa Program';
    }
}
