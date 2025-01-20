<?php

namespace App\Filament\Resources\KelasAnsaResource\Pages;

use App\Filament\Resources\KelasAnsaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Support\Htmlable;

class ManageKelasAnsas extends ManageRecords
{
    protected static string $resource = KelasAnsaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Kelas Ansa';
    }
}
