<?php

namespace App\Filament\Admin\Resources\KategoriMentoringResource\Pages;

use App\Filament\Admin\Resources\KategoriMentoringResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriMentoring extends EditRecord
{
    protected static string $resource = KategoriMentoringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Edit Kategori Mentoring';
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
