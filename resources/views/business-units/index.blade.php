@extends('layouts.site')

@section('meta_title', 'Strategic Business Units | Hasnur Group')
@section('meta_description', 'Tujuh strategic business unit Hasnur Group dengan landing page detail dan entitas anak usaha.')

@section('content')
    <section class="hsnr-page-hero">
        <div class="hsnr-shell">
            <p class="hsnr-eyebrow">Strategic Business Unit</p>
            <h1>Strategic Business Units</h1>
            <p class="hsnr-lead">Tujuh pilar bisnis Hasnur Group disusun sebagai landing page yang rapi, konsisten, dan mudah diperdalam.</p>
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell">
            <div class="hsnr-grid hsnr-grid--3">
                @foreach ($businessUnits as $unit)
                    <article id="hsnr-sbu-{{ $unit->slug }}" class="hsnr-card hsnr-sbu-card hsnr-sbu-card--{{ $unit->slug }}" style="--hsnr-accent: {{ $unit->extraValue('accent', '#0f766e') }};" data-reveal>
                        <p class="hsnr-card__label">{{ $unit->title }}</p>
                        <h2>{{ $unit->subtitle }}</h2>
                        <p>{{ $unit->summary }}</p>
                        @if ($unit->children->isNotEmpty())
                            <div class="hsnr-chip-row">
                                @foreach ($unit->children as $entity)
                                    <span>{{ $entity->title }}</span>
                                @endforeach
                            </div>
                        @endif
                        <a class="hsnr-link" href="{{ route('business-units.show', $unit->slug) }}">Lihat detail SBU</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
