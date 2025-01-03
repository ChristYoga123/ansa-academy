<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\KategoriMentoring;
use App\Models\Mentoring;
use Illuminate\Http\Request;

class MentoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Mentoring::withCount(['mentors', 'testimoni', 'pakets'])
                         ->orderBy('testimoni_count', 'desc');

        // Filter by category if provided
        if ($request->category && $request->category !== 'all') {
            $query->where('kategori_mentoring_id', $request->category);
        }

        $mentoring = $query->paginate(5)->withQueryString();
        $kategoriMentoring = KategoriMentoring::all();

        if ($request->ajax()) {
            // Hanya mengembalikan konten mentoring cards
            $view = view('pages.mentoring.index', [
                'mentorings' => $mentoring,
                'kategoriMentorings' => $kategoriMentoring,
                'title' => 'Mentoring'  // Tambahkan title disini
            ])->renderSections()['content']; // Ambil hanya bagian content

            return response()->json([
                'html' => $view,
                'hasMore' => $mentoring->hasMorePages()
            ]);
        }

        return view('pages.mentoring.index', [
            'title' => 'Mentoring',
            'mentorings' => $mentoring,
            'kategoriMentorings' => $kategoriMentoring
        ]);
    }
}
