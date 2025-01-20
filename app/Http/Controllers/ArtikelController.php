<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public $title = 'Artikel';

    public function index(Request $request)
    {
        $query = Artikel::with('media')
                        ->orderBy('created_at', 'desc');

        $featuredArticle = null;
        $searchQuery = $request->get('search');

        if ($searchQuery) {
            // When searching, don't show featured article
            $query->where(function($q) use ($searchQuery) {
                $q->where('judul', 'like', '%' . $searchQuery . '%');
                // ->orWhere('content', 'like', '%' . $searchQuery . '%');
            });
        } else {
            // Only get featured article if not searching and on first page
            if (!$request->has('page') || $request->get('page') == 1) {
                $featuredArticle = $query->first();
                if ($featuredArticle) {
                    $query->where('id', '!=', $featuredArticle->id);
                }
            }
        }
        
        $articles = $query->paginate(6)->withQueryString();

        if ($request->ajax()) {
            $view = view('pages.artikel.index', [
                'articles' => $articles,
                'featuredArticle' => $searchQuery ? null : $featuredArticle,
                'title' => $this->title
            ])->renderSections()['content'];

            return response()->json([
                'html' => $view,
                'hasMore' => $articles->hasMorePages()
            ]);
        }

        return view('pages.artikel.index', [
            'title' => $this->title,
            'articles' => $articles,
            'featuredArticle' => $searchQuery ? null : $featuredArticle
        ]);
    }

    public function show($slug)
    {
        $article = Artikel::with('media')->where('slug', $slug)->firstOrFail();
        
        // Get random related articles from same category
        $relatedArticles = Artikel::with('media')->where('id', '!=', $article->id)
                                ->inRandomOrder()
                                ->limit(3)
                                ->get();

        return view('pages.artikel.show', [
            'title' => $article->judul,
            'article' => $article,
            'relatedArticles' => $relatedArticles
        ]);
    }
}