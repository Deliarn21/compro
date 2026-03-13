@extends('layouts.site')

@section('meta_title', 'Hasnur Group | Corporate Portal')
@section('meta_description', 'Corporate profile, business units, CSR, media center, and contact directory for Hasnur Group.')

@section('content')
    @php
        $profile = $corporatePages->get('company-profile');
    @endphp

    <section class="hsnr-hero">
        <div class="hsnr-shell hsnr-hero__grid">
            <div data-reveal>
                <p class="hsnr-eyebrow">Corporate Portal</p>
                <h1>Hasnur Group</h1>
                <p class="hsnr-lead">Platform korporat yang merangkum identitas perusahaan, strategic business units, inisiatif sosial, publikasi resmi, dan kanal komunikasi dalam tampilan yang lebih modern dan profesional.</p>
                <div class="hsnr-hero__actions">
                    <a class="hsnr-button" href="{{ route('corporate.index') }}">Profil Korporat</a>
                    <a class="hsnr-button hsnr-button--ghost" href="{{ route('media-center.index') }}">Media Center</a>
                </div>
                <div class="hsnr-metric-grid">
                    <div class="hsnr-metric"><strong>1966</strong><span>Tahun Berdiri</span></div>
                    <div class="hsnr-metric"><strong>{{ $businessUnits->count() }}</strong><span>Unit Bisnis Strategis</span></div>
                    <div class="hsnr-metric"><strong>{{ $csrPillars->count() }}</strong><span>Pilar CSR</span></div>
                    <div class="hsnr-metric"><strong>{{ $publications->count() }}</strong><span>Publikasi Terkini</span></div>
                </div>
            </div>
            <div class="hsnr-hero__panel" data-reveal>
                <div class="hsnr-hero__bloom"></div>
                <div class="hsnr-hero__gridlines" aria-hidden="true"></div>
                <div class="hsnr-card hsnr-card--glass">
                    <p class="hsnr-card__label">Corporate Overview</p>
                    <h2>Portal ini menampilkan skala bisnis dan arah perusahaan secara lebih ringkas, kredibel, dan mudah dijelajahi.</h2>
                    <p>{{ $profile?->summary }}</p>
                    <ul class="hsnr-list">
                        <li>Corporate identity dan milestone tetap menjadi fondasi utama.</li>
                        <li>Setiap SBU memiliki struktur halaman yang lebih konsisten.</li>
                        <li>Media center dan contact directory tetap siap dikembangkan lebih lanjut.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell">
            <div class="hsnr-section__heading" data-reveal>
                <p class="hsnr-eyebrow">Sekilas Perusahaan</p>
                <h2>Corporate identity, sejarah, nilai, dan kepemimpinan dalam struktur yang lebih rapi.</h2>
            </div>
            <div class="hsnr-grid hsnr-grid--4">
                @foreach ($corporatePages as $page)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ strtoupper(str_replace('-', ' ', $page->slug)) }}</p>
                        <h3>{{ $page->title }}</h3>
                        <p>{{ $page->summary }}</p>
                        <a class="hsnr-link" href="{{ $page->slug === 'company-profile' ? route('corporate.index') : route('corporate.show', $page->slug) }}">Buka halaman</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="hsnr-section hsnr-section--tinted">
        <div class="hsnr-shell">
            <div class="hsnr-section__heading" data-reveal>
                <p class="hsnr-eyebrow">Strategic Business Units</p>
                <h2>Tujuh pilar bisnis ditata ulang dengan pendekatan visual yang lebih terstruktur.</h2>
            </div>
            <div class="hsnr-grid hsnr-grid--3">
                @foreach ($businessUnits as $unit)
                    <article id="hsnr-sbu-{{ $unit->slug }}" class="hsnr-card hsnr-sbu-card hsnr-sbu-card--{{ $unit->slug }}" style="--hsnr-accent: {{ $unit->extraValue('accent', '#0f766e') }};" data-reveal>
                        <p class="hsnr-card__label">{{ $unit->title }}</p>
                        <h3>{{ $unit->subtitle }}</h3>
                        <p>{{ $unit->summary }}</p>
                        @if ($unit->children->isNotEmpty())
                            <div class="hsnr-chip-row">
                                @foreach ($unit->children->take(3) as $entity)
                                    <span>{{ $entity->title }}</span>
                                @endforeach
                            </div>
                        @endif
                        <a class="hsnr-link" href="{{ route('business-units.show', $unit->slug) }}">Lihat detail unit</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell hsnr-split">
            <div data-reveal>
                <p class="hsnr-eyebrow">Milestone</p>
                <h2>Perjalanan Hasnur Group sejak 1966 hingga transformasi terkini.</h2>
                <p class="hsnr-lead">Timeline perusahaan tetap hadir sebagai penanda pertumbuhan jangka panjang dalam format yang lebih mudah dipindai.</p>
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

    <section class="hsnr-section hsnr-section--tinted">
        <div class="hsnr-shell">
            <div class="hsnr-section__heading" data-reveal>
                <p class="hsnr-eyebrow">CSR & Impact</p>
                <h2>Komitmen sosial dan keberlanjutan yang tersaji lebih jelas untuk publik.</h2>
            </div>
            <div class="hsnr-grid hsnr-grid--4">
                @foreach ($csrPillars as $pillar)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ $pillar->title }}</p>
                        <h3>{{ $pillar->extraValue('impact') }}</h3>
                        <p>{{ $pillar->summary }}</p>
                        <a class="hsnr-link" href="{{ route('csr.show', $pillar->slug) }}">Telusuri pilar</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell">
            <div class="hsnr-section__heading" data-reveal>
                <p class="hsnr-eyebrow">Media Center</p>
                <h2>Publikasi perusahaan tersusun dalam arsip yang lebih bersih dan mudah dipindai.</h2>
            </div>
            <div class="hsnr-grid hsnr-grid--3">
                @foreach ($publications as $publication)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ strtoupper($publication->category ?? 'NEWS') }}</p>
                        <h3>{{ $publication->title }}</h3>
                        <p>{{ $publication->summary }}</p>
                        <a class="hsnr-link" href="{{ route('media-center.show', [$publication->category, $publication->slug]) }}">Baca detail</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="hsnr-section hsnr-section--footer-cta">
        <div class="hsnr-shell hsnr-grid hsnr-grid--2">
            <div class="hsnr-card hsnr-card--accent" data-reveal>
                <p class="hsnr-eyebrow">Leadership</p>
                <h2>Struktur manajemen dirancang agar mudah diperbarui seiring perkembangan organisasi.</h2>
                <div class="hsnr-chip-row">
                    @foreach ($executives as $executive)
                        <span>{{ $executive->title }}</span>
                    @endforeach
                </div>
            </div>
            <div class="hsnr-grid hsnr-grid--1">
                @foreach ($locations as $location)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ $location->title }}</p>
                        <h3>{{ $location->subtitle }}</h3>
                        <p>{{ $location->summary }}</p>
                        <a class="hsnr-link" href="{{ route('contact.index') }}">Lihat contact directory</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
