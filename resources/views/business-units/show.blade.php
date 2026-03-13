@extends('layouts.site')

@section('meta_title', $businessUnit->title.' | Hasnur Group')
@section('meta_description', $businessUnit->summary)

@section('content')
    <section class="hsnr-page-hero" style="--hsnr-accent: {{ $businessUnit->extraValue('accent', '#0f766e') }};">
        <div class="hsnr-shell hsnr-grid hsnr-grid--2">
            <div>
                <p class="hsnr-eyebrow">Strategic Business Unit</p>
                <h1>{{ $businessUnit->title }}</h1>
                <p class="hsnr-lead">{{ $businessUnit->subtitle }}</p>
                <p>{{ $businessUnit->summary }}</p>
            </div>
            <div class="hsnr-card hsnr-card--glass">
                <p class="hsnr-card__label">Design note</p>
                <p>Komponen SBU diimplementasikan dengan class dan ID unik seperti <code>#hsnr-sbu-{{ $businessUnit->slug }}</code> dan <code>.hsnr-accordion-{{ $businessUnit->slug }}</code> agar aman terhadap konflik style.</p>
            </div>
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell hsnr-grid hsnr-grid--3">
            <div class="hsnr-panel hsnr-panel--wide">
                <div class="hsnr-richtext">{!! $businessUnit->body !!}</div>

                @if ($businessUnit->children->isNotEmpty())
                    <div class="hsnr-accordion hsnr-accordion-{{ $businessUnit->slug }}">
                        <h2>Entitas terkait</h2>
                        <div class="hsnr-grid hsnr-grid--2">
                            @foreach ($businessUnit->children as $entity)
                                <article class="hsnr-card" data-reveal>
                                    <p class="hsnr-card__label">{{ $entity->extraValue('code') }}</p>
                                    <h3>{{ $entity->title }}</h3>
                                    <p>{{ $entity->subtitle }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <aside class="hsnr-panel">
                <p class="hsnr-card__label">Related Units</p>
                <div class="hsnr-stack">
                    @foreach ($relatedUnits as $unit)
                        <a class="hsnr-side-link" href="{{ route('business-units.show', $unit->slug) }}">
                            <strong>{{ $unit->title }}</strong>
                            <span>{{ $unit->summary }}</span>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </section>

    <section class="hsnr-section hsnr-section--tinted">
        <div class="hsnr-shell">
            <div class="hsnr-section__heading" data-reveal>
                <p class="hsnr-eyebrow">Latest Media</p>
                <h2>Storytelling tiap unit bisa langsung terhubung dengan publikasi korporat terbaru.</h2>
            </div>
            <div class="hsnr-grid hsnr-grid--3">
                @foreach ($latestPublications as $publication)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ strtoupper($publication->category) }}</p>
                        <h3>{{ $publication->title }}</h3>
                        <p>{{ $publication->summary }}</p>
                        <a class="hsnr-link" href="{{ route('media-center.show', [$publication->category, $publication->slug]) }}">Buka publikasi</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
