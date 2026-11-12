@extends('layouts.guest-adminlte')
@section('content')
    <h2 class="auth-card-title mb-2">Pilih Akses Login Anda</h2>
    <p class="auth-card-subtitle mb-4">Silakan pilih role Anda untuk masuk ke sistem SIMADE.</p>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    {{-- Note: Success flash is handled at the layout level per requirements --}}

    <div class="row g-3">
        <div class="col-sm-6">
            <form method="POST" action="{{ route('pilih-role') }}">
                @csrf
                <input type="hidden" name="role" value="mahasiswa">
                <button type="submit" class="btn btn-outline-secondary w-100 h-100 text-start d-flex flex-column align-items-center justify-content-center p-4 border-2 role-btn">
                    <i class="bi bi-mortarboard fs-1 mb-3 text-emerald"></i>
                    <h5 class="mb-1 fw-bold text-dark">Mahasiswa</h5>
                    <p class="small text-secondary mb-0">Dashboard akademik mahasiswa</p>
                </button>
            </form>
        </div>
        <div class="col-sm-6">
            <form method="POST" action="{{ route('pilih-role') }}">
                @csrf
                <input type="hidden" name="role" value="dosen">
                <button type="submit" class="btn btn-outline-secondary w-100 h-100 text-start d-flex flex-column align-items-center justify-content-center p-4 border-2 role-btn">
                    <i class="bi bi-briefcase fs-1 mb-3 text-emerald"></i>
                    <h5 class="mb-1 fw-bold text-dark">Dosen</h5>
                    <p class="small text-secondary mb-0">Dashboard pengajar & statistik</p>
                </button>
            </form>
        </div>
    </div>

    <div class="mt-4 text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-secondary text-decoration-none small">
                Batal & Logout
            </button>
        </form>
    </div>

    @push('styles')
    <style>
        .role-btn {
            background-color: #ffffff;
            border-color: #cbd5e1;
            transition: all 150ms ease;
            min-height: 160px;
        }
        .role-btn:hover {
            background-color: #f0fdf4;
            border-color: #059669;
            color: inherit;
        }
        .role-btn:focus-visible {
            outline: 3px solid #059669;
            outline-offset: 2px;
        }
        .text-emerald {
            color: #059669 !important;
        }
    </style>
    @endpush
@endsection