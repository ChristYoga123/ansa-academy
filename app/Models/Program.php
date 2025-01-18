<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Program extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function programJasa()
    {
        return $this->belongsTo(ProgramJasa::class);
    }

    public function mentors()
    {
        return $this->belongsToMany(User::class, 'program_mentors', 'program_id', 'mentor_id')->withPivot('id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('program-thumbnail')
            ->singleFile();
    }
}
