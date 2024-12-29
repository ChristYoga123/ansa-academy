<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentoring extends Model
{
    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(KategoriMentoring::class);
    }

    public function bidangs()
    {
        return $this->hasMany(MentoringBidang::class);
    }

    public function pakets()
    {
        return $this->hasMany(MentoringPaket::class);
    }

    public function mentors()
    {
        return $this->belongsToMany(User::class, 'mentoring_mentors', 'mentoring_id', 'mentor_id')->withPivot('id');
    }
}
