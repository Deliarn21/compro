<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('meta_title', 'Admin | Hasnur Group')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/hasnur.css') }}">
</head>
<body class="hsnr-admin-page">
    <div class="hsnr-admin">
        <aside class="hsnr-admin__sidebar">
            <a class="hsnr-brand" href="{{ route('admin.dashboard') }}">
                <span class="hsnr-brand__mark">HG</span>
                <span>
                    <strong>Admin Panel</strong>
                    <small>Hasnur Group CMS</small>
                </span>
            </a>

            <nav class="hsnr-admin__nav">
                <a @class(['is-active' => request()->routeIs('admin.dashboard')]) href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a @class(['is-active' => request()->is('admin/content/pages*')]) href="{{ route('admin.contents.index', 'pages') }}">Halaman</a>
                <a @class(['is-active' => request()->is('admin/content/business-units*')]) href="{{ route('admin.contents.index', 'business-units') }}">Business Units</a>
                <a @class(['is-active' => request()->is('admin/content/business-entities*')]) href="{{ route('admin.contents.index', 'business-entities') }}">Entitas</a>
                <a @class(['is-active' => request()->is('admin/content/milestones*')]) href="{{ route('admin.contents.index', 'milestones') }}">Milestones</a>
                <a @class(['is-active' => request()->is('admin/content/executives*')]) href="{{ route('admin.contents.index', 'executives') }}">Manajemen</a>
                <a @class(['is-active' => request()->is('admin/content/csr-pillars*')]) href="{{ route('admin.contents.index', 'csr-pillars') }}">Pilar CSR</a>
                <a @class(['is-active' => request()->is('admin/content/publications*')]) href="{{ route('admin.contents.index', 'publications') }}">Publikasi</a>
                <a @class(['is-active' => request()->is('admin/content/locations*')]) href="{{ route('admin.contents.index', 'locations') }}">Lokasi</a>
                <a @class(['is-active' => request()->routeIs('admin.redirects.*')]) href="{{ route('admin.redirects.index') }}">Redirects</a>
                <a href="{{ route('home') }}">Lihat website</a>
            </nav>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="hsnr-button hsnr-button--ghost hsnr-button--full" type="submit">Logout</button>
            </form>
        </aside>

        <div class="hsnr-admin__content">
            @if (session('status'))
                <div class="hsnr-alert">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="hsnr-alert hsnr-alert--error">{{ $errors->first() }}</div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
