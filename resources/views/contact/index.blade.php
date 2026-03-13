@extends('layouts.site')

@section('meta_title', 'Contact & Directory | Hasnur Group')
@section('meta_description', 'Informasi kantor pusat, kantor perwakilan, dan contact form Hasnur Group.')

@section('content')
    <section class="hsnr-page-hero">
        <div class="hsnr-shell">
            <p class="hsnr-eyebrow">Contact & Directory</p>
            <h1>Contact & Directory</h1>
            <p class="hsnr-lead">Informasi kantor, kanal korporat, dan formulir inquiry umum ditampilkan dalam struktur yang jelas dan profesional.</p>
        </div>
    </section>

    <section class="hsnr-section">
        <div class="hsnr-shell hsnr-grid hsnr-grid--2">
            <div class="hsnr-grid hsnr-grid--1">
                @foreach ($locations as $location)
                    <article class="hsnr-card" data-reveal>
                        <p class="hsnr-card__label">{{ $location->title }}</p>
                        <h2>{{ $location->subtitle }}</h2>
                        <p>{{ $location->summary }}</p>
                        <div class="hsnr-contact-meta">
                            <span>{{ $location->extraValue('phone') }}</span>
                            <span>{{ $location->extraValue('email') }}</span>
                        </div>
                    </article>
                @endforeach
            </div>

            <form class="hsnr-form" method="POST" action="{{ route('contact.store') }}" data-reveal>
                @csrf
                <p class="hsnr-card__label">Contact Form</p>
                <h2>Kirim inquiry umum</h2>
                <div class="hsnr-form__grid">
                    <label>
                        <span>Nama</span>
                        <input type="text" name="name" value="{{ old('name') }}" required>
                    </label>
                    <label>
                        <span>Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </label>
                    <label>
                        <span>Telepon</span>
                        <input type="text" name="phone" value="{{ old('phone') }}">
                    </label>
                    <label>
                        <span>Perusahaan</span>
                        <input type="text" name="company" value="{{ old('company') }}">
                    </label>
                </div>
                <label>
                    <span>Subjek</span>
                    <input type="text" name="subject" value="{{ old('subject') }}" required>
                </label>
                <label>
                    <span>Pesan</span>
                    <textarea name="message" rows="6" required>{{ old('message') }}</textarea>
                </label>
                <label class="hsnr-checkbox">
                    <input type="checkbox" name="consent" value="1" {{ old('consent') ? 'checked' : '' }} required>
                    <span>Saya menyetujui penggunaan data untuk kebutuhan tindak lanjut inquiry.</span>
                </label>
                <button class="hsnr-button" type="submit">Kirim pesan</button>
            </form>
        </div>
    </section>
@endsection
