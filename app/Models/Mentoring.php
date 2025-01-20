<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Mentoring extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = ucwords($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    public function mentoringPakets()
    {
        return $this->hasMany(MentoringPaket::class);
    }

    public function mentoringBidangs()
    {
        return $this->hasMany(MentoringBidang::class);
    }

    public function mentors()
    {
        return $this->belongsToMany(User::class, 'mentoring_mentors', 'mentoring_id', 'mentor_id')->withPivot('id');
    }

    public function mentoringMentees()
    {
        return $this->hasManyThrough(MentoringMentee::class, MentoringPaket::class, 'mentoring_id', 'mentoring_paket_id', 'id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('mentoring-thumbnail')
            ->singleFile();
    }
}
