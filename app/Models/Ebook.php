<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ebook extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
        $this->slug = Str::slug($value);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ebook-thumbnail')
            ->singleFile();
        $this->addMediaCollection('ebook-file')
            ->singleFile();
    }
}
