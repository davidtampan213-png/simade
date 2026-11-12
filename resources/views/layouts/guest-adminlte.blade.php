<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'SIMADE') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=source-sans-3:400,500,600,700|source-serif-4:600,700&display=swap" rel="stylesheet">
    @vite(['resources/scss/adminlte.scss', 'resources/js/adminlte.js'])

    <style>
        body.auth-page {
            --simade-emerald: #047857;
            --simade-emerald-dark: #065f46;
            min-height: 100vh;
            background-color: #f4f7f5;
            color: #1f2937;
            font-family: 'Source Sans 3', sans-serif;
            position: relative;
        }
        
        /* Subtle campus photo overlay on auth pages (per user requirement) */
        body.auth-page::before {
            content: "";
            position: fixed;
            inset: 0;
            background: url('/images/bg-login.jpg') center / cover no-repeat;
            opacity: 0.08;
            pointer-events: none;
            z-index: 0;
        }
        
        .auth-shell { 
            min-height: 100vh; 
            position: relative;
            z-index: 1;
        }
        
        /* Solid light background without blur or transparency */
        .auth-main { 
            padding: 2rem 1rem;
            background-color: #f4f7f5;
        }
        
        /* Brand panel with solid emerald background */
        .auth-brand-panel {
            background-color: #065f46;
            color: #fff;
            padding: 3rem;
            border-right: 1px solid #044e39;
        }
        .auth-brand-inner { max-width: 27rem; }
        .auth-brand-row {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .auth-logo {
            width: auto;
            height: 64px;
            object-fit: contain;
        }
        .auth-brand-title {
            margin: 0;
            line-height: 1;
            font-family: 'Source Serif 4', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            letter-spacing: .02em;
            color: #ffffff;
        }
        .auth-brand-copy {
            margin-top: 0.75rem;
        }
        .auth-brand-copy { 
            color: #d1fae5; 
            font-size: 1rem; 
            line-height: 1.65; 
        }
        
        /* Solid white login card without resting shadow */
        .auth-card { width: 100%; max-width: 31rem; }
        .auth-card .card { 
            background-color: #ffffff;
            border: 1px solid #dce5e0; 
            border-top: 4px solid var(--simade-emerald); 
            box-shadow: none;
        }
        .auth-card-title { font-family: 'Source Serif 4', serif; color: #12372a; font-size: 1.6rem; }
        .auth-card-subtitle { color: #4b5563; font-size: .95rem; }
        .auth-page .form-control, .auth-page .form-check-input { border-radius: .25rem; border-color: #cbd5e1; }
        .auth-page .form-control:focus { border-color: var(--simade-emerald); box-shadow: 0 0 0 0.2rem rgba(4, 120, 87, 0.15); }
        .auth-page .form-control { min-height: 2.75rem; }
        .auth-page .btn { border-radius: .25rem; font-weight: 600; }
        .auth-page .btn-primary { background-color: var(--simade-emerald); border-color: var(--simade-emerald); color: #ffffff; }
        .auth-page .btn-primary:hover, .auth-page .btn-primary:focus { background-color: var(--simade-emerald-dark); border-color: var(--simade-emerald-dark); }
        .auth-page a { color: var(--simade-emerald); }
        .auth-page a:hover { color: var(--simade-emerald-dark); }
        @media (max-width: 991.98px) { 
            .auth-brand-panel { padding: 2rem 1.5rem; border-right: none; border-bottom: 1px solid #044e39; } 
            .auth-logo { height: 56px; }
        }
    </style>
    @stack('styles')
</head>
<body class="auth-page">
    <a href="#main-content" class="visually-hidden-focusable position-absolute top-0 start-0 m-2 p-2 bg-white text-success z-3 rounded border">Lewati ke konten utama</a>
    <div class="container-fluid auth-shell p-0">
        <div class="row g-0 min-vh-100">
            <aside class="col-lg-5 d-flex align-items-center auth-brand-panel">
                <div class="auth-brand-inner mx-lg-auto">
                    <div class="auth-brand-row">
                        <img src="{{ asset('logo.png') }}" alt="Logo SIMADE" class="auth-logo">
                        <h1 class="auth-brand-title">SIMADE</h1>
                    </div>
                    <p class="mb-0 auth-brand-copy">Sistem Informasi Manajemen Dosen</p>
                </div>
            </aside>
            <main class="col-lg-7 d-flex align-items-center justify-content-center auth-main" id="main-content" tabindex="-1">
                <div class="auth-card">
                    <div class="card">
                        <div class="card-body p-4 p-md-5">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>