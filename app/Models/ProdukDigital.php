<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProdukDigital extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $guarded = ['id'];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = ucwords($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    public function transaksis()
    {
        return $this->morphMany(Transaksi::class, 'transaksiable');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('produk-digital-thumbnail')
            ->singleFile();
        $this->addMediaCollection('produk-digital-file')
            ->singleFile();
    }
}
