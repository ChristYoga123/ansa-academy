<?php

namespace App\Models;

use App\LokerMentor\MahasiswaBerprestrasiEnum;
use App\LokerMentor\SemesterEnum;
use App\LokerMentor\StatusPenerimaanEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class LokerMentor extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'pencapaian' => 'array',
        'semester' => SemesterEnum::class,
        'mahasiswa_berprestrasi' => MahasiswaBerprestrasiEnum::class,
        'status_penerimaan' => StatusPenerimaanEnum::class,
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('calon-mentor-cv')
            ->singleFile();
    }
}
