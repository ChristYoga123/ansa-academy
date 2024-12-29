<?php

namespace App\Filament\Admin\Resources\KategoriMentoringResource\Pages;

use App\Filament\Admin\Resources\KategoriMentoringResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListKategoriMentorings extends ListRecords
{
    protected static string $resource = KategoriMentoringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Kategori Mentoring';
    }
}
