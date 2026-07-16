@php
use Illuminate\Support\Str;
@endphp
@extends('layouts.app')
@section('content')

<h2 class="page-title mb-4">Global Supply Chain News</h2>
<div class="card card-custom p-4">

    <div class="table-responsive">
        <table class="table table-hover">

            <thead>
            <tr>
                <th>Country</th>
                <th>Title</th>
                <th>Source</th>
                <th>Sentiment</th>
                <th>Date</th>
                <th>Link</th>
            </tr>
            </thead>

            <tbody>

            @foreach($news as $article)

            <tr>

                <td>
                    {{ optional($article->country)->country_name ?? 'Global' }}
                </td>
                <td>
                    {{ Str::limit($article->title, 80) }}
                </td>
                <td>
                    {{ $article->source_name }}
                </td>

                <td>

                    @if(optional($article->sentiment)->sentiment == 'Positive')
                        <span class="badge bg-success">Positive</span>
                    @elseif(optional($article->sentiment)->sentiment == 'Negative')
                        <span class="badge bg-danger">Negative</span>
                    @else
                        <span class="badge bg-secondary">Neutral</span>
                    @endif

                </td>

                <td>
                    {{ optional($article->published_at)->format('d M Y') }}
                </td>

                <td>
                    <a href="{{ $article->article_url }}" target="_blank" class="btn btn-sm btn-outline-dark">
                        Open
                    </a>
                </td>
            </tr>

            @endforeach

            </tbody>
        </table>
    </div>
</div>

@endsection
