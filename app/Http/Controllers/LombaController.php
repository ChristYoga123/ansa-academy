<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use Illuminate\Http\Request;

class LombaController extends Controller
{
    public $title = 'Lomba';

    public function index(Request $request)
    {
        $now = now();
        $query = Lomba::query()
                    ->with('media')
                    ->orderBy('waktu_open_registrasi', 'desc');

        // Filter by status if provided
        if ($request->status && $request->status !== 'all') {
            if ($request->status === 'open') {
                $query->where('waktu_open_registrasi', '<=', $now)
                    ->where('waktu_close_registrasi', '>=', $now);
            } else if ($request->status === 'closed') {
                $query->where(function($q) use ($now) {
                    $q->where('waktu_close_registrasi', '<', $now)
                    ->orWhere('waktu_open_registrasi', '>', $now);
                });
            }
        }

        // Add search functionality
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                ->orWhere('penyelenggara', 'like', '%' . $request->search . '%');
            });
        }

        $lombas = $query->paginate(6)->withQueryString();

        // Get counts for the status tabs
        $statusCounts = [
            'total' => Lomba::with('media')->count(),
            'open' => Lomba::with('media')->where('waktu_open_registrasi', '<=', $now)
                        ->where('waktu_close_registrasi', '>=', $now)
                        ->count(),
            'closed' => Lomba::with('media')->where(function($q) use ($now) {
                            $q->where('waktu_close_registrasi', '<', $now)
                            ->orWhere('waktu_open_registrasi', '>', $now);
                        })->count()
        ];

        if ($request->ajax()) {
            $view = view('pages.lomba.index', [
                'lombas' => $lombas,
                'statusCounts' => $statusCounts,
                'title' => 'Lomba'
            ])->renderSections()['content'];

            return response()->json([
                'html' => $view,
                'hasMore' => $lombas->hasMorePages()
            ]);
        }

        return view('pages.lomba.index', [
            'title' => 'Lomba',
            'lombas' => $lombas,
            'statusCounts' => $statusCounts
        ]);
    }

    public function show($slug)
    {
        $lomba = Lomba::with('media')->where('slug', $slug)->firstOrFail();
        
        $relatedLombas = Lomba::with('media')->where('id', '!=', $lomba->id)
                             ->orderBy('created_at', 'desc')
                             ->inRandomOrder()
                             ->limit(3)
                             ->get();

        return view('pages.lomba.show', [
            'title' => $lomba->judul,
            'lomba' => $lomba,
            'relatedLombas' => $relatedLombas
        ]);
    }
}