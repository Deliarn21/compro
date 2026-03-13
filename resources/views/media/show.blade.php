@extends('layouts.site')

@section('meta_title', $publication->title.' | Hasnur Group')
@section('meta_description', $publication->summary)

@section('content')
    <section class="hsnr-page-hero">
        <div class="hsnr-shell hsnr-grid hsnr-grid--2">
            <div>
                <p class="hsnr-eyebrow">{{ strtoupper($publication->category) }}</p>
                <h1>{{ $publication->title }}</h1>
                <p class="hsnr-lead">{{ $publication->summary }}</p>
                <p class="hsnr-meta">Published {{ optional($publication->published_at)->format('d M Y') }} by {{ $publication->extraValue('author', 'Corporate Communication') }}</p>
            </div>
            <div class="hsnr-card hsnr-card--glass">
                <p class="hsnr-card__label">Media Type</p>
                <h2>{{ $mediaTypes[$selectedType] ?? strtoupper($selectedType) }}</h2>
                <p>URL publikasi ini siap menerima redirect dari struktur lama seperti <code>/post/news/*</code> atau <code>/post/press-release/*</code>.</p>
            </div>
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell hsnr-grid hsnr-grid--3">
            <div class="hsnr-panel hsnr-panel--wide">
                <div class="hsnr-richtext">{!! $publication->body !!}</div>
            </div>
            <aside class="hsnr-panel">
                <p class="hsnr-card__label">Related Media</p>
                <div class="hsnr-stack">
                    @foreach ($relatedPublications as $item)
                        <a class="hsnr-side-link" href="{{ route('media-center.show', [$item->category, $item->slug]) }}">
                            <strong>{{ $item->title }}</strong>
                            <span>{{ $item->summary }}</span>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </section>
@endsection
