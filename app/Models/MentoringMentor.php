<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentoringMentor extends Model
{
    protected $guarded = ['id'];

    public function mentoring()
    {
        return $this->belongsTo(Mentoring::class);
    }

    public function mentor()
    {
        return $this->belongsTo(User::class);
    }
}
