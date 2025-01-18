<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramTestimoni extends Model
{
    protected $guarded = ['id'];

    public function mentee()
    {
        return $this->belongsTo(User::class, 'mentee_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
