<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalysisArticle;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleManagementController extends Controller
{
    public function index(Request $request)
{
    $articles =
        AnalysisArticle::with(
            'country'
        )

        ->when(
            $request->search,
            function ($query) use ($request) {

                $query->where(
                    'title',
                    'like',
                    '%' .
                    $request->search .
                    '%'
                );
            }
        )

        ->when(
            $request->status,
            function ($query) use ($request) {
                $query->where(
                    'status',
                    $request->status
                );
            }
        )

        ->latest()
        ->paginate(20)
        ->withQueryString();

    return view(
        'admin.articles.index',
        compact('articles')
    );
}

    public function create()
    {
        $countries = Country::orderBy('country_name')->get();
        return view('admin.articles.create', compact('countries'));
    }

    public function store(
        Request $request
    )
    {
        $request->validate([

            'title' =>
                'required',
            'category' =>
                'required',
            'content' =>
                'required'
        ]);

        AnalysisArticle::create([

            'title' =>
                $request->title,
            'slug' =>
                Str::slug(
                    $request->title
                ),
            'country_id' =>
                $request->country_id,
            'category' =>
                $request->category,
            'summary' =>
                $request->summary,
            'content' =>
                $request->content,

            'author' =>
                auth()->user()->name,

            'status' =>
                $request->status,

            'published_at' =>
                $request->status
                === 'published'
                    ? now()
                    : null
        ]);

        return redirect(
            '/admin/articles'
        );
    }

    public function edit($id)
    {
        $article =
            AnalysisArticle::findOrFail($id);

        $countries =
            Country::orderBy(
                'country_name'
            )->get();

        return view(
            'admin.articles.edit',
            compact(
                'article',
                'countries'
            )
        );
    }

    public function update(
        Request $request,
        $id
    )
    {
        $article =
            AnalysisArticle::findOrFail($id);

        $article->update([

            'title' =>
                $request->title,

            'slug' =>
                Str::slug(
                    $request->title
                ),

            'country_id' =>
                $request->country_id,
            'category' =>
                $request->category,
            'summary' =>
                $request->summary,
            'content' =>
                $request->content,
            'status' =>
                $request->status,

            'published_at' =>
                $request->status
                === 'published'
                    ? now()
                    : null
        ]);

        return redirect(
            '/admin/articles'
        );
    }

    public function destroy($id)
    {
        AnalysisArticle::destroy(
            $id
        );

        return back();
    }
}