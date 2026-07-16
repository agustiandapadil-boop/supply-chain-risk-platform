@extends('layouts.app')
@section('content')

<div class="mb-4">
    <a href="/ui/articles" class="text-muted text-decoration-none small">
        &larr; Back to Articles
    </a>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card card-custom p-4 p-md-5">

            <div class="d-flex gap-2 mb-3 flex-wrap align-items-center">
                <span class="badge" style="background:#6366f1;">{{ $article->category }}</span>
                @if($article->country)
                <span class="text-muted small">{{ $article->country->country_name }}</span>
                @endif
            </div>

            <h1 class="fw-bold mb-3" style="font-size:1.75rem;line-height:1.3;">
                {{ $article->title }}
            </h1>

            @if($article->summary)
            <p class="lead text-muted mb-4" style="font-size:1rem;line-height:1.7;">
                {{ $article->summary }}
            </p>
            @endif

            <div class="d-flex gap-3 text-muted small mb-4 pb-3" style="border-bottom:1px solid rgba(0,0,0,.08);">
                <span>By <strong>{{ $article->author }}</strong></span>
                <span>{{ optional($article->published_at)->format('d M Y') }}</span>
            </div>

            <div style="line-height:1.85; white-space:pre-wrap; word-break:break-word;">
                {!! nl2br(e($article->content)) !!}
            </div>
        </div>
    </div>

    <div class="col-md-4">

        @if($related->isNotEmpty())
        <div class="card card-custom p-4 mb-4">
            <h6 class="fw-bold mb-3">Related Articles</h6>
            @foreach($related as $rel)
            <a href="/ui/articles/{{ $rel->slug }}" class="d-block text-decoration-none mb-3">
                <div class="p-3 rounded-2" style="background:var(--bg-secondary,#f8f9fa); transition:background .15s;" onmouseover="this.style.background='#ede9fe'" onmouseout="this.style.background=''">
                    <div class="small fw-semibold mb-1" style="color:var(--text-primary,#111);line-height:1.4;">{{ $rel->title }}</div>
                    <div class="text-muted" style="font-size:.75rem;">{{ optional($rel->published_at)->format('d M Y') }}</div>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        <div class="card card-custom p-4">
            <h6 class="fw-bold mb-2">Article Info</h6>
            <table class="table table-sm mb-0" style="font-size:.85rem;">
                <tr><td class="text-muted">Category</td><td>{{ $article->category }}</td></tr>
                <tr><td class="text-muted">Author</td><td>{{ $article->author }}</td></tr>
                <tr><td class="text-muted">Published</td><td>{{ optional($article->published_at)->format('d M Y') }}</td></tr>
                <tr><td class="text-muted">Country</td><td>{{ optional($article->country)->country_name ?? 'Global' }}</td></tr>
            </table>
        </div>
    </div>
</div>

@endsection
