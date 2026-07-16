@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-0">Analysis Articles</h2>
        <p class="text-muted small mb-0">Latest supply chain intelligence from our analysts</p>
    </div>
</div>

@if($articles->isEmpty())
    <div class="card card-custom p-5 text-center text-muted">
        <p class="mb-0">No published articles yet.</p>
    </div>
@else

<div class="row g-4">
    @foreach($articles as $article)
    <div class="col-md-4">
        <a href="/ui/articles/{{ $article->slug }}" class="text-decoration-none">
            <div class="card card-custom p-4 h-100" style="transition:transform .18s,box-shadow .18s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 32px rgba(0,0,0,.12)'" onmouseout="this.style.transform='';this.style.boxShadow=''">

                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge" style="background:#6366f1;font-size:.75rem;">{{ $article->category }}</span>
                    @if($article->country)
                    <span class="text-muted small">{{ $article->country->country_name }}</span>
                    @endif
                </div>

                <h5 class="fw-bold mb-2" style="line-height:1.4; color:var(--text-primary, #111);">
                    {{ $article->title }}
                </h5>

                @if($article->summary)
                <p class="text-muted small mb-3" style="line-height:1.6;">
                    {{ \Illuminate\Support\Str::limit($article->summary, 120) }}
                </p>
                @endif

                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <small class="text-muted">{{ $article->author }}</small>
                    <small class="text-muted">{{ optional($article->published_at)->format('d M Y') }}</small>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
<div class="mt-4">
    {{ $articles->links() }}
</div>

@endif
@endsection
