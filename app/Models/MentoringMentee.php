<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MentoringMentee extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function mentee()
    {
        return $this->belongsTo(User::class, 'mentee_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function mentoringBidang()
    {
        return $this->belongsTo(MentoringBidang::class, 'mentoring_bidang_id');
    }

    public function mentoringPaket()
    {
        return $this->belongsTo(MentoringPaket::class, 'mentoring_paket_id');
    }

    public function transaksis()
    {
        return $this->morphMany(Transaksi::class, 'transaksiable');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('file-mentee-lanjutan')
            ->singleFile();
    }
}
