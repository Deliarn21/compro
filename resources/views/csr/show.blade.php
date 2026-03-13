@extends('layouts.site')

@section('meta_title', $pillar->title.' | Hasnur Group')
@section('meta_description', $pillar->summary)

@section('content')
    <section class="hsnr-page-hero">
        <div class="hsnr-shell hsnr-grid hsnr-grid--2">
            <div>
                <p class="hsnr-eyebrow">CSR Pillar</p>
                <h1>{{ $pillar->title }}</h1>
                <p class="hsnr-lead">{{ $pillar->extraValue('impact') }}</p>
                <p>{{ $pillar->summary }}</p>
            </div>
            <div class="hsnr-card hsnr-card--glass">
                <p class="hsnr-card__label">Pilar Description</p>
                <div class="hsnr-richtext">{!! $pillar->body !!}</div>
            </div>
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell">
            <div class="hsnr-section__heading" data-reveal>
                <p class="hsnr-eyebrow">Other Pillars</p>
                <h2>Portal CSR tetap fleksibel untuk berkembang menjadi katalog program yang lebih luas.</h2>
            </div>
            <div class="hsnr-grid hsnr-grid--3">
                @foreach ($pillars as $item)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ $item->title }}</p>
                        <h3>{{ $item->extraValue('impact') }}</h3>
                        <p>{{ $item->summary }}</p>
                        <a class="hsnr-link" href="{{ route('csr.show', $item->slug) }}">Buka pilar</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
