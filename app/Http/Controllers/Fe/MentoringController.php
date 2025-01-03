<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\Mentoring;
use Illuminate\Http\Request;

class MentoringController extends Controller
{
    public function index()
    {
        $mentoring = Mentoring::withCount('mentors')->withCount('testimoni')->withCount('pakets')->orderBy('testimoni_count', 'desc')->paginate(5);

        return view('pages.mentoring.index', [
            'title' => 'Mentoring',
            'mentorings' => $mentoring
        ]);
    }
}
