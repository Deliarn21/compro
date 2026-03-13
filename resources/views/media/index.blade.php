@extends('layouts.site')

@section('meta_title', 'Media Center | Hasnur Group')
@section('meta_description', 'News, press release, multimedia, gallery, dan arsip publikasi Hasnur Group.')

@section('content')
    <section class="hsnr-page-hero">
        <div class="hsnr-shell">
            <p class="hsnr-eyebrow">Media Center</p>
            <h1>Media Center</h1>
            <p class="hsnr-lead">Arsip berita, press release, multimedia, dan gallery ditata untuk menjaga kontinuitas SEO sekaligus memudahkan pengelolaan konten.</p>
            <div class="hsnr-filter-row">
                @foreach ($mediaTypes as $type => $label)
                    <a @class(['is-active' => $selectedType === $type]) href="{{ $type === 'all' ? route('media-center.index') : route('media-center.type', $type) }}">{{ $label }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="hsnr-section hsnr-section--tinted">
        <div class="hsnr-shell">
            <div class="hsnr-grid hsnr-grid--3">
                @foreach ($featuredPublications as $publication)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ strtoupper($publication->category) }}</p>
                        <h3>{{ $publication->title }}</h3>
                        <p>{{ $publication->summary }}</p>
                        <a class="hsnr-link" href="{{ route('media-center.show', [$publication->category, $publication->slug]) }}">Baca detail</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell">
            <div class="hsnr-grid hsnr-grid--3">
                @foreach ($publications as $publication)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ strtoupper($publication->category) }}</p>
                        <h3>{{ $publication->title }}</h3>
                        <p>{{ $publication->summary }}</p>
                        <a class="hsnr-link" href="{{ route('media-center.show', [$publication->category, $publication->slug]) }}">Baca detail</a>
                    </article>
                @endforeach
            </div>

            @if ($publications->hasPages())
                <div class="hsnr-pagination">
                    @if ($publications->previousPageUrl())
                        <a class="hsnr-button hsnr-button--ghost" href="{{ $publications->previousPageUrl() }}">Previous</a>
                    @endif
                    <span>Page {{ $publications->currentPage() }} of {{ $publications->lastPage() }}</span>
                    @if ($publications->nextPageUrl())
                        <a class="hsnr-button hsnr-button--ghost" href="{{ $publications->nextPageUrl() }}">Next</a>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
