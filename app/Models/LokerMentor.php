<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class LokerMentor extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'pencapaian' => 'json',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('calon-mentor-cv')
            ->singleFile();
    }
}
