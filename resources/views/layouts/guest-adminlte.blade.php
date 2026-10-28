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
        
        // Foto latar samar di halaman auth (logo.png di atas foto)
        body.auth-page::before {
            content: "";
            position: fixed;
            inset: 0;
            background: url('/images/bg-login.jpg') center / cover no-repeat;
            opacity: 0.10;
            pointer-events: none;
            z-index: 0;
        }
        
        .auth-shell { 
            min-height: 100vh; 
            position: relative;
            z-index: 1;
        }
        
        /* Konten utama area abu muda tanpa foto */
        .auth-main { 
            padding: 2rem 1rem;
            background-color: rgba(244, 247, 245, 0.9);
            backdrop-filter: blur(4px);
        }
        
        .auth-brand-panel {
            background: linear-gradient(160deg, #064e3b 0%, #047857 100%);
            color: #fff;
            padding: 3rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .auth-brand-inner { max-width: 27rem; }
        .auth-logo {
            width: 76px;
            height: 76px;
            object-fit: contain;
            background: #fff;
            border: 3px solid rgba(255,255,255,.78);
            border-radius: .25rem;
            padding: .2rem;
        }
        .auth-brand-title {
            margin: 1.5rem 0 .35rem;
            font-family: 'Source Serif 4', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            letter-spacing: .02em;
        }
        .auth-brand-copy { color: rgba(255,255,255,.78); font-size: 1rem; line-height: 1.65; }
        .auth-main { padding: 2rem 1rem; }
        .auth-card { width: 100%; max-width: 31rem; }
        .auth-card .card { border: 1px solid #dce5e0; border-top: 4px solid var(--simade-emerald); box-shadow: 0 2px 8px rgba(20, 55, 43, .08); }
        .auth-card-title { font-family: 'Source Serif 4', serif; color: #12372a; font-size: 1.6rem; }
        .auth-card-subtitle { color: #64748b; font-size: .95rem; }
        .auth-page .form-control, .auth-page .form-check-input { border-radius: .25rem; }
        .auth-page .form-control { min-height: 2.75rem; }
        .auth-page .btn { border-radius: .25rem; font-weight: 600; }
        .auth-page .btn-primary { background-color: var(--simade-emerald); border-color: var(--simade-emerald); }
        .auth-page .btn-primary:hover, .auth-page .btn-primary:focus { background-color: var(--simade-emerald-dark); border-color: var(--simade-emerald-dark); }
        .auth-page a { color: var(--simade-emerald); }
        .auth-page a:hover { color: var(--simade-emerald-dark); }
        @media (max-width: 991.98px) { .auth-brand-panel { padding: 2rem 1.5rem; } .auth-brand-title { margin-top: 1rem; } }
    </style>
    @stack('styles')
</head>
<body class="auth-page">
    <a href="#main-content" class="visually-hidden-focusable position-absolute top-0 start-0 m-2 p-2 bg-white text-success z-3 rounded">Lewati ke konten utama</a>
    <div class="container-fluid auth-shell p-0">
        <div class="row g-0 min-vh-100">
            <aside class="col-lg-5 d-flex align-items-center auth-brand-panel">
                <div class="auth-brand-inner mx-lg-auto">
                    <img src="{{ asset('logo.png') }}" alt="Logo SIMADE" class="auth-logo">
                    <h1 class="auth-brand-title">SIMADE</h1>
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
