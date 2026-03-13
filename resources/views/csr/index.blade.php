@extends('layouts.site')

@section('meta_title', 'CSR & Hasnur Centre | Hasnur Group')
@section('meta_description', $page->summary)

@section('content')
    <section class="hsnr-page-hero">
        <div class="hsnr-shell">
            <p class="hsnr-eyebrow">CSR Portal</p>
            <h1>{{ $page->title }}</h1>
            <p class="hsnr-lead">{{ $page->summary }}</p>
            <div class="hsnr-richtext">{!! $page->body !!}</div>
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell">
            <div class="hsnr-grid hsnr-grid--4">
                @foreach ($pillars as $pillar)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ $pillar->title }}</p>
                        <h2>{{ $pillar->extraValue('impact') }}</h2>
                        <p>{{ $pillar->summary }}</p>
                        <a class="hsnr-link" href="{{ route('csr.show', $pillar->slug) }}">Open pillar</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="hsnr-section hsnr-section--tinted">
        <div class="hsnr-shell">
            <div class="hsnr-section__heading" data-reveal>
                <p class="hsnr-eyebrow">Recent Stories</p>
                <h2>Aktivitas sosial tetap dapat dikemas sebagai konten reputasi yang kuat.</h2>
            </div>
            <div class="hsnr-grid hsnr-grid--3">
                @foreach ($stories as $story)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ strtoupper($story->category) }}</p>
                        <h3>{{ $story->title }}</h3>
                        <p>{{ $story->summary }}</p>
                        <a class="hsnr-link" href="{{ route('media-center.show', [$story->category, $story->slug]) }}">Lihat publikasi</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
