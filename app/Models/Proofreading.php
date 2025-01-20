<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Proofreading extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = ucwords($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    public function proofreadingPakets()
    {
        return $this->hasMany(ProofreadingPaket::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('proofreading-thumbnail')
            ->singleFile();
    }
}
