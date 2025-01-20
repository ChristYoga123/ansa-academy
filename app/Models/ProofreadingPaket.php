<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProofreadingPaket extends Model
{
    protected $guarded = ['id'];

    public function proofreading()
    {
        return $this->belongsTo(Proofreading::class);
    }
}
