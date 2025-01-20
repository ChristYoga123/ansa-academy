<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class KelasAnsa extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = ucwords($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    public function kelasAnsaPakets()
    {
        return $this->hasMany(KelasAnsaPaket::class);
    }

    public function mentors()
    {
        return $this->belongsToMany(User::class, 'kelas_ansa_mentors', 'kelas_ansa_id', 'mentor_id')->withPivot('id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('kelas-ansa-thumbnail')
            ->singleFile();
    }
}
