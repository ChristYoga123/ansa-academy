<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lomba extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;
    
    protected $guarded = ['id'];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = ucwords($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    protected $casts = [
        'waktu_open_registrasi' => 'datetime',
        'waktu_close_registrasi' => 'datetime',
    ];

    public function getIsOpenAttribute()
    {
        $now = now();
        return $this->waktu_open_registrasi <= $now && $this->waktu_close_registrasi >= $now;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('lomba-thumbnail')
            ->singleFile();
    }
}
