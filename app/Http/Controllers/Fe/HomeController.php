<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\Mentoring;
use App\Models\TestimoniProduk;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil Mentoring dengan Jumlah Mentor yang tergabung tetapi berdasarkan testimoni terbanyak
        $populerMentoring = Mentoring::withCount('mentors')->withCount('testimoni')->withCount('pakets')->orderBy('testimoni_count', 'desc')->limit(3)->get();
        $mentor = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'mentor');
        })->limit(4)->get();
        $testimoni = TestimoniProduk::with(['user'])->orderBy('created_at', 'desc')->limit(10)->get();
        return view('pages.home.index', [
            'title' => 'Welcome',
            'populerMentoring' => $populerMentoring,
            'mentors' => $mentor,
            'testimonis' => $testimoni
        ]);
    }
}
