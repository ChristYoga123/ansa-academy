<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProofreadingMentee extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function transaksis()
    {
        return $this->morphMany(Transaksi::class, 'transaksiable');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('proofreading-file')
            ->singleFile();
        $this->addMediaCollection('proofreading-file-finished')
            ->singleFile();
    }
}
