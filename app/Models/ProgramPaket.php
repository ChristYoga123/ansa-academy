<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramPaket extends Model
{
    protected $guarded = ['id'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
