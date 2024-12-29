<?php

namespace App\Filament\Admin\Resources\KategoriMentoringResource\Pages;

use App\Filament\Admin\Resources\KategoriMentoringResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKategoriMentoring extends CreateRecord
{
    protected static string $resource = KategoriMentoringResource::class;

    public function getTitle(): string
    {
        return 'Tambah Kategori Mentoring';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
