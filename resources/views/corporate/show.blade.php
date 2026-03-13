@extends('layouts.site')

@section('meta_title', $page->title.' | Hasnur Group')
@section('meta_description', $page->summary)

@section('content')
    <section class="hsnr-page-hero">
        <div class="hsnr-shell hsnr-grid hsnr-grid--2">
            <div>
                <p class="hsnr-eyebrow">Corporate Module</p>
                <h1>{{ $page->title }}</h1>
                <p class="hsnr-lead">{{ $page->summary }}</p>
            </div>
            <div class="hsnr-card hsnr-card--glass">
                <p class="hsnr-card__label">Why this page matters</p>
                <p>Modul ini dipertahankan agar struktur informasi lama tetap utuh sambil mendapatkan layout yang lebih bersih, responsif, dan siap SEO.</p>
            </div>
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell hsnr-grid hsnr-grid--3">
            <div class="hsnr-panel hsnr-panel--wide">
                <div class="hsnr-richtext">{!! $page->body !!}</div>

                @if ($page->slug === 'history')
                    <div class="hsnr-timeline">
                        @foreach ($milestones as $milestone)
                            <article class="hsnr-timeline__item" data-reveal>
                                <span>{{ $milestone->extraValue('year') }}</span>
                                <div>
                                    <h3>{{ $milestone->title }}</h3>
                                    <p>{{ $milestone->summary }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

                @if ($page->slug === 'management')
                    <div class="hsnr-grid hsnr-grid--3">
                        @foreach ($executives as $executive)
                            <article class="hsnr-card" data-reveal>
                                <p class="hsnr-card__label">{{ $executive->extraValue('role') }}</p>
                                <h3>{{ $executive->title }}</h3>
                                <p>{{ $executive->summary }}</p>
                            </article>
                        @endforeach
                    </div>
                @endif

                @if ($page->slug === 'core-values')
                    <div class="hsnr-chip-row hsnr-chip-row--large">
                        @foreach (['Agile', 'Caring', 'Committed', 'Creative', 'Integrity', 'Nationalism', 'Professional', 'Teamwork'] as $value)
                            <span>{{ $value }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            <aside class="hsnr-panel">
                <p class="hsnr-card__label">Related Pages</p>
                <div class="hsnr-stack">
                    @foreach ($relatedPages as $relatedPage)
                        <a class="hsnr-side-link" href="{{ $relatedPage->slug === 'company-profile' ? route('corporate.index') : route('corporate.show', $relatedPage->slug) }}">
                            <strong>{{ $relatedPage->title }}</strong>
                            <span>{{ $relatedPage->summary }}</span>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </section>
@endsection
