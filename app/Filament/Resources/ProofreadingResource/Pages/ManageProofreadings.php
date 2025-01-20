<?php

namespace App\Filament\Resources\ProofreadingResource\Pages;

use App\Filament\Resources\ProofreadingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Support\Htmlable;

class ManageProofreadings extends ManageRecords
{
    protected static string $resource = ProofreadingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Proofreading';
    }
}
