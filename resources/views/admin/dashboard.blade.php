@extends('admin.layouts.app')

@section('meta_title', 'Dashboard | Hasnur Group Admin')

@section('content')
    <div class="hsnr-admin__header">
        <div>
            <p class="hsnr-eyebrow">Dashboard</p>
            <h1>Ringkasan konten dan traffic entry points.</h1>
        </div>
    </div>

    <div class="hsnr-grid hsnr-grid--4">
        <div class="hsnr-card"><p class="hsnr-card__label">Pages</p><h2>{{ $stats['pages'] }}</h2></div>
        <div class="hsnr-card"><p class="hsnr-card__label">Business Units</p><h2>{{ $stats['business_units'] }}</h2></div>
        <div class="hsnr-card"><p class="hsnr-card__label">Publications</p><h2>{{ $stats['publications'] }}</h2></div>
        <div class="hsnr-card"><p class="hsnr-card__label">Inquiries</p><h2>{{ $stats['inquiries'] }}</h2></div>
    </div>

    <div class="hsnr-grid hsnr-grid--2">
        <section class="hsnr-panel">
            <div class="hsnr-admin__section-title">
                <h2>Recent Inquiries</h2>
            </div>
            <div class="hsnr-admin__table-wrap">
                <table class="hsnr-admin__table">
                    <thead>
                        <tr><th>Nama</th><th>Subjek</th><th>Email</th><th>Tanggal</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($recentInquiries as $inquiry)
                            <tr>
                                <td>{{ $inquiry->name }}</td>
                                <td>{{ $inquiry->subject }}</td>
                                <td>{{ $inquiry->email }}</td>
                                <td>{{ $inquiry->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4">Belum ada inquiry yang masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="hsnr-panel">
            <div class="hsnr-admin__section-title">
                <h2>Recent Publications</h2>
            </div>
            <div class="hsnr-stack">
                @foreach ($recentPublications as $publication)
                    <div class="hsnr-side-link">
                        <strong>{{ $publication->title }}</strong>
                        <span>{{ strtoupper($publication->category) }} • {{ optional($publication->published_at)->format('d M Y') }}</span>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
