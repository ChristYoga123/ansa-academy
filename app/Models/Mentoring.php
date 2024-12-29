<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Mentoring extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriMentoring::class, 'kategori_mentoring_id');
    }

    public function bidangs()
    {
        return $this->hasMany(MentoringBidang::class, 'mentoring_id', 'id');
    }

    public function pakets()
    {
        return $this->hasMany(MentoringPaket::class, 'mentoring_id', 'id');
    }

    public function mentors()
    {
        return $this->belongsToMany(User::class, 'mentoring_mentors', 'mentoring_id', 'mentor_id')->withPivot('id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('mentoring-thumbnail')
            ->singleFile();
    }
}
