<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentoringBidang extends Model
{
    protected $guarded = ['id'];

    public function mentoring()
    {
        return $this->belongsTo(Mentoring::class);
    }
}
