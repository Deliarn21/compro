@extends('layouts.site')

@section('meta_title', $page->title.' | Hasnur Group')
@section('meta_description', $page->summary)

@section('content')
    <section class="hsnr-page-hero">
        <div class="hsnr-shell">
            <p class="hsnr-eyebrow">Corporate Identity</p>
            <h1>{{ $page->title }}</h1>
            <p class="hsnr-lead">{{ $page->summary }}</p>
            <div class="hsnr-richtext">{!! $page->body !!}</div>
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell">
            <div class="hsnr-grid hsnr-grid--4">
                @foreach ($relatedPages as $relatedPage)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ strtoupper(str_replace('-', ' ', $relatedPage->slug)) }}</p>
                        <h3>{{ $relatedPage->title }}</h3>
                        <p>{{ $relatedPage->summary }}</p>
                        <a class="hsnr-link" href="{{ route('corporate.show', $relatedPage->slug) }}">Buka detail</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="hsnr-section hsnr-section--tinted">
        <div class="hsnr-shell hsnr-split">
            <div>
                <p class="hsnr-eyebrow">Milestones</p>
                <h2>Timeline perjalanan bisnis tetap menjadi pilar penting untuk kredibilitas dan storytelling perusahaan.</h2>
            </div>
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
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell">
            <div class="hsnr-section__heading" data-reveal>
                <p class="hsnr-eyebrow">Management</p>
                <h2>Profil kepemimpinan yang siap diperbarui tanpa mengubah struktur halaman.</h2>
            </div>
            <div class="hsnr-grid hsnr-grid--4">
                @foreach ($executives as $executive)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ $executive->extraValue('role') }}</p>
                        <h3>{{ $executive->title }}</h3>
                        <p>{{ $executive->summary }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
