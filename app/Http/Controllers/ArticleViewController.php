<?php

namespace App\Http\Controllers;

use App\Models\AnalysisArticle;

class ArticleViewController extends Controller
{
    public function index()
    {
        $articles = AnalysisArticle::with('country')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(12);

        return view('articles.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = AnalysisArticle::with('country')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $related = AnalysisArticle::with('country')
            ->where('status', 'published')
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->limit(4)
            ->get();

        return view('articles.show', compact('article', 'related'));
    }
}
