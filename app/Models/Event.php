<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    protected $casts = [
        'waktu_open_registrasi' => 'datetime',
        'waktu_close_registrasi' => 'datetime',
        'waktu_pelaksanaan' => 'datetime',
    ];

    public function mentors()
    {
        return $this->belongsToMany(User::class, 'event_mentors', 'event_id', 'mentor_id')->withPivot('id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('event-thumbnail')
            ->singleFile();
    }
}
