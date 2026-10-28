<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* ===== BASE ===== */
            *, *::before, *::after { box-sizing: border-box; }

            body {
                font-family: 'Inter', 'Figtree', sans-serif;
                min-height: 100vh;
                margin: 0;
                padding: 0;
                background: #064e3b;
            }

            /* ===== BACKGROUND ===== */
            .simade-bg {
                position: fixed;
                inset: 0;
                z-index: 0;
                background-image: url('{{ asset('images/bg-login.jpg') }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            }

            /* Overlay: transparan lebih rendah agar foto kampus tetap terlihat */
            .simade-bg::after {
                content: '';
                position: absolute;
                inset: 0;
                /* Overlay gradient dua lapis: hijau tua sangat transparan */
                background:
                    linear-gradient(
                        160deg,
                        rgba(2, 44, 34, 0.62) 0%,
                        rgba(4, 80, 56, 0.52) 50%,
                        rgba(5, 105, 70, 0.45) 100%
                    );
            }

            /* ===== DEKORASI BLUR ===== */
            .simade-deco {
                position: fixed;
                border-radius: 50%;
                pointer-events: none;
                z-index: 1;
                filter: blur(60px);
                opacity: 0.18;
            }
            .simade-deco-1 {
                width: 420px; height: 420px;
                background: radial-gradient(circle, #34d399 0%, transparent 70%);
                top: -120px; right: -100px;
            }
            .simade-deco-2 {
                width: 300px; height: 300px;
                background: radial-gradient(circle, #6ee7b7 0%, transparent 70%);
                bottom: -80px; left: -80px;
            }

            /* ===== WRAPPER SCROLL ===== */
            .simade-scroll-wrap {
                position: relative;
                z-index: 10;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2.5rem 1rem;
            }

            /* ===== KONTEN TENGAH ===== */
            .simade-center {
                width: 100%;
                max-width: 430px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            /* ===== LOGO ===== */
            .simade-logo-wrap {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin-bottom: 1.75rem;
                text-align: center;
            }

            .simade-logo-img-ring {
                padding: 4px;
                border-radius: 50%;
                background: linear-gradient(135deg, #10b981, #34d399);
                box-shadow:
                    0 0 0 3px rgba(16,185,129,0.25),
                    0 8px 28px rgba(0,0,0,0.35);
                margin-bottom: 0.9rem;
            }

            .simade-logo-img-ring img {
                display: block;
                width: 90px;
                height: 90px;
                border-radius: 50%;
                border: 3px solid #fff;
                object-fit: cover;
                background: #fff;
            }

            .simade-logo-title {
                font-size: 1.65rem;
                font-weight: 800;
                color: #ffffff;
                letter-spacing: 0.12em;
                text-shadow: 0 2px 10px rgba(0,0,0,0.4);
                margin: 0;
                line-height: 1.2;
            }

            .simade-logo-subtitle {
                font-size: 0.8rem;
                color: rgba(255,255,255,0.72);
                margin-top: 0.3rem;
                letter-spacing: 0.04em;
                font-weight: 400;
            }

            /* ===== KARTU FORM ===== */
            .simade-card {
                width: 100%;
                background: #ffffff;
                border-radius: 16px;
                border-top: 4px solid #10b981;
                padding: 2rem 2.25rem 1.75rem;
                box-shadow:
                    0 20px 50px rgba(0,0,0,0.22),
                    0 4px 12px rgba(0,0,0,0.10);
            }

            /* ===== RESPONSIF ===== */
            @media (max-width: 480px) {
                .simade-card {
                    padding: 1.5rem 1.25rem 1.25rem;
                    border-radius: 14px;
                }
                .simade-logo-img-ring img {
                    width: 78px;
                    height: 78px;
                }
                .simade-logo-title {
                    font-size: 1.45rem;
                }
            }
        </style>
    </head>
    <body>

        <!-- Background foto kampus -->
        <div class="simade-bg"></div>

        <!-- Dekorasi blur -->
        <div class="simade-deco simade-deco-1"></div>
        <div class="simade-deco simade-deco-2"></div>

        <!-- Scroll wrapper -->
        <div class="simade-scroll-wrap">
            <div class="simade-center">

                <!-- Logo & Identitas -->
                <div class="simade-logo-wrap">
                    <div class="simade-logo-img-ring">
                        <img src="{{ asset('logo.png') }}" alt="Logo SIMADE">
                    </div>
                    <h1 class="simade-logo-title">SIMADE</h1>
                    <p class="simade-logo-subtitle">Sistem Informasi Manajemen Dosen</p>
                </div>

                <!-- Kartu Form -->
                <div class="simade-card">
                    {{ $slot }}
                </div>

            </div>
        </div>

    </body>
</html>
