<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use App\Models\Iklan;
use App\Models\User;
use App\Models\Mentoring;
use Illuminate\Http\Request;
use App\Models\TestimoniProduk;

class BerandaController extends Controller
{
    public $title = 'Selamat Datang';

    public function index()
    {
        return view('pages.beranda.index', [
            'title' => $this->title,
            'mentorings' => Mentoring::with('media')->withCount('mentors')->withCount('mentoringPakets')->withCount('mentoringMentees')->limit(3)->get(),
            'testimonies' => [],
            'faqs' => [],
            'iklans' => [],
        ]);
    }
}
