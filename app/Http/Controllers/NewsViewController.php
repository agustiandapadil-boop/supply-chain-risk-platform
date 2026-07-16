<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;

class NewsViewController extends Controller
{
    public function index()
    {
        $news = NewsArticle::with(['country', 'sentiment'])
            ->latest('published_at')
            ->limit(50)
            ->get();

        return view('news.index', compact('news'));
    }
}
