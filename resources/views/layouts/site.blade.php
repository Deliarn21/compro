<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('meta_title', 'Hasnur Group')</title>
    <meta name="description" content="@yield('meta_description', 'Corporate website for Hasnur Group.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/hasnur.css') }}">
    <script defer src="{{ asset('assets/js/hasnur.js') }}"></script>
</head>
<body class="@yield('body_class', 'hsnr-page')">
    <div class="hsnr-noise" aria-hidden="true"></div>

    <header class="hsnr-header">
        <div class="hsnr-shell hsnr-header__inner">
            <a class="hsnr-brand" href="{{ route('home') }}">
                <span class="hsnr-brand__mark">HG</span>
                <span>
                    <strong>Hasnur Group</strong>
                    <small>Corporate Portal</small>
                </span>
            </a>

            <button class="hsnr-nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="hsnr-nav">
                Menu
            </button>

            <nav class="hsnr-nav" id="hsnr-nav" data-nav-panel>
                <a @class(['is-active' => request()->routeIs('corporate.*')]) href="{{ route('corporate.index') }}">Corporate</a>
                <a @class(['is-active' => request()->routeIs('business-units.*')]) href="{{ route('business-units.index') }}">SBU</a>
                <a @class(['is-active' => request()->routeIs('csr.*')]) href="{{ route('csr.index') }}">CSR</a>
                <a @class(['is-active' => request()->routeIs('media-center.*')]) href="{{ route('media-center.index') }}">Media Center</a>
                <a @class(['is-active' => request()->routeIs('contact.*')]) href="{{ route('contact.index') }}">Contact</a>
                <a href="{{ route('corporate.show', 'hse-overview') }}">K3L</a>
                <a href="{{ route('corporate.show', 'careers') }}">Career</a>
                <a class="hsnr-nav__admin" href="{{ route('login') }}">Admin</a>
            </nav>
        </div>
    </header>

    @if (session('status'))
        <div class="hsnr-shell">
            <div class="hsnr-alert">{{ session('status') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="hsnr-shell">
            <div class="hsnr-alert hsnr-alert--error">
                {{ $errors->first() }}
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="hsnr-footer">
        <div class="hsnr-shell hsnr-footer__grid">
            <div>
                <p class="hsnr-eyebrow">Hasnur Group</p>
                <h2>Platform korporat untuk profil perusahaan, lini bisnis, publikasi resmi, dan inisiatif sosial Hasnur Group.</h2>
            </div>
            <div class="hsnr-footer__links">
                <a href="{{ route('corporate.index') }}">Corporate Identity</a>
                <a href="{{ route('business-units.index') }}">Strategic Business Unit</a>
                <a href="{{ route('csr.index') }}">CSR & Hasnur Centre</a>
                <a href="{{ route('media-center.index') }}">Media Center</a>
                <a href="{{ route('contact.index') }}">Contact Directory</a>
            </div>
            <div class="hsnr-footer__meta">
                <p>Head Office Banjarmasin</p>
                <p>Jakarta Representative Office</p>
                <p>{{ now()->year }} Hasnur Group</p>
            </div>
        </div>
    </footer>
</body>
</html>
