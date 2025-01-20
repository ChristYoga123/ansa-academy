<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasAnsaMentee extends Model
{
    protected $guarded = ['id'];

    public function kelasAnsaPaket()
    {
        return $this->belongsTo(KelasAnsaPaket::class);
    }

    public function mentee()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksis()
    {
        return $this->morphMany(Transaksi::class, 'transaksiable');
    }
}
