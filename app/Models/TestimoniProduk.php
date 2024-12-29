<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimoniProduk extends Model
{
    protected $guarded = ['id'];

    public function mentoring()
    {
        return $this->belongsTo(Mentoring::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
