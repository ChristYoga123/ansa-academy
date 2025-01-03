<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProdukDigital extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('produk-digital-thumbnail')
            ->singleFile();
        $this->addMediaCollection('produk-digital-file')
            ->singleFile();
    }
}
