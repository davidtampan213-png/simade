<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'SIMADE') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/scss/adminlte.scss', 'resources/js/adminlte.js'])
    @stack('styles')
</head>
<body class="{{ session('active_role') === 'dosen' ? 'layout-dosen' : 'layout-mahasiswa' }} layout-fixed sidebar-expand-lg bg-body-tertiary">
    <a href="#main-content" class="visually-hidden-focusable position-absolute top-0 start-0 m-2 p-2 bg-white text-success z-3 rounded">Lewati ke konten utama</a>

    <div class="app-wrapper">
        @include('layouts.partials.navbar')
        @include('layouts.partials.sidebar')

        <main class="app-main" id="main-content" tabindex="-1">
            @isset($header)
                <div class="app-content-header border-bottom bg-white">
                    <div class="container-fluid px-3 px-md-4 py-3">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <div class="app-content">
                <div class="container-fluid px-3 px-md-4 py-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-start gap-2" role="alert">
                            <i class="bi bi-check-circle-fill mt-1"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Tutup"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start gap-2" role="alert">
                            <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                            <div>{{ session('error') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Tutup"></button>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </div>
        </main>

        @include('layouts.partials.footer')
    </div>

    @stack('scripts')
</body>
</html>