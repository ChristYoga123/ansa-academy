<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class KategoriMentoring extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $guarded = ['id'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('kategori-mentoring-thumbnail')
            ->singleFile();
    }
}
