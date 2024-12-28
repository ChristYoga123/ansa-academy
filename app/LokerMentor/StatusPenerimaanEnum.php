<?php

namespace App\LokerMentor;

enum StatusPenerimaanEnum: string
{
    case MENUNGGU = 'Menunggu';
    case DITERIMA = 'Diterima';
    case DITOLAK = 'Ditolak';
}
