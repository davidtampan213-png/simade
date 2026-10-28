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
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-sm-6">
            <form method="POST" action="{{ route('pilih-role') }}">
                @csrf
                <input type="hidden" name="role" value="mahasiswa">
                <button type="submit" class="btn btn-outline-primary w-100 h-100 text-start d-flex flex-column align-items-center justify-content-center p-4">
                    <i class="bi bi-mortarboard fs-1 mb-3 text-primary"></i>
                    <h5 class="mb-1 fw-bold">Mahasiswa</h5>
                    <p class="small text-muted mb-0">Dashboard akademik mahasiswa</p>
                </button>
            </form>
        </div>
        <div class="col-sm-6">
            <form method="POST" action="{{ route('pilih-role') }}">
                @csrf
                <input type="hidden" name="role" value="dosen">
                <button type="submit" class="btn btn-outline-success w-100 h-100 text-start d-flex flex-column align-items-center justify-content-center p-4">
                    <i class="bi bi-briefcase fs-1 mb-3 text-success"></i>
                    <h5 class="mb-1 fw-bold">Dosen</h5>
                    <p class="small text-muted mb-0">Dashboard pengajar & statistik</p>
                </button>
            </form>
        </div>
    </div>

    <div class="mt-4 text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-muted text-decoration-none small">
                Batal & Logout
            </button>
        </form>
    </div>
@endsection