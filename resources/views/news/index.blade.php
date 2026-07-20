@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')

<h2 class="page-title mb-4">Global Supply Chain News</h2>

<div class="row">

    @foreach($news as $article)

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card h-100 shadow-sm border-0">

                {{-- Gambar Berita --}}
                <img
                    src="{{ $article->image_url ?? 'https://via.placeholder.com/600x350?text=No+Image' }}"
                    class="card-img-top"
                    alt="{{ $article->title }}"
                    style="height:220px; object-fit:cover;"
                >

                <div class="card-body d-flex flex-column">

                    {{-- Negara --}}
                    <div class="d-flex align-items-center gap-2 mb-2">

                        @if(optional($article->country)->iso2)
                            <x-country-flag :iso2="$article->country->iso2" />
                        @endif

                        <small class="text-muted">
                            {{ optional($article->country)->country_name ?? 'Global' }}
                        </small>

                    </div>

                    {{-- Judul --}}
                    <h5 class="card-title">
                        {{ Str::limit($article->title, 100) }}
                    </h5>

                    {{-- Source --}}
                    <small class="text-muted mb-2">
                        {{ $article->source_name }}
                    </small>

                    {{-- Sentiment --}}
                    <div class="mb-3">

                        @if(optional($article->sentiment)->sentiment == 'Positive')
                            <span class="badge bg-success">Positive</span>
                        @elseif(optional($article->sentiment)->sentiment == 'Negative')
                            <span class="badge bg-danger">Negative</span>
                        @else
                            <span class="badge bg-secondary">Neutral</span>
                        @endif

                    </div>

                    {{-- Tanggal --}}
                    <small class="text-muted mb-3">
                        {{ optional($article->published_at)->format('d M Y') }}
                    </small>

                    {{-- Tombol --}}
                    <div class="mt-auto">
                        <a href="{{ $article->article_url }}"
                           target="_blank"
                           class="btn btn-primary w-100">
                            Read News
                        </a>
                    </div>

                </div>

            </div>

        </div>

    @endforeach

</div>

@endsection