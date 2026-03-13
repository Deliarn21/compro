<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Hasnur Group</title>
    <link rel="stylesheet" href="{{ asset('assets/css/hasnur.css') }}">
</head>
<body class="hsnr-admin-page hsnr-admin-page--login">
    <div class="hsnr-login-card">
        <p class="hsnr-eyebrow">Hasnur Group CMS</p>
        <h1>Admin Login</h1>
        <p>Masuk ke panel manajemen konten untuk mengelola corporate profile, SBU, CSR, publikasi, dan redirect legacy.</p>

        @if ($errors->any())
            <div class="hsnr-alert hsnr-alert--error">{{ $errors->first() }}</div>
        @endif

        <form class="hsnr-form" method="POST" action="{{ route('admin.login.store') }}">
            @csrf
            <label>
                <span>Email</span>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>
            <label>
                <span>Password</span>
                <input type="password" name="password" required>
            </label>
            <label class="hsnr-checkbox">
                <input type="checkbox" name="remember" value="1">
                <span>Keep me signed in</span>
            </label>
            <button class="hsnr-button" type="submit">Login</button>
        </form>
    </div>
</body>
</html>
