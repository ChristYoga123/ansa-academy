<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMentor extends Model
{
    protected $guarded = ['id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function mentor()
    {
        return $this->belongsTo(User::class);
    }
}
