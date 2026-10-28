@extends('layouts.guest-adminlte')
@section('content')
    <h2 class="auth-card-title mb-1">Lupa Password?</h2>
    <p class="auth-card-subtitle mb-4">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </p>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="contoh@email.com"
                required
                autofocus
                class="form-control @error('email') is-invalid @enderror"
            >
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">
            {{ __('Email Password Reset Link') }}
        </button>

        <p class="text-center small mt-4 mb-0">
            Kembali ke
            <a href="{{ route('login') }}" class="fw-semibold ms-1">
                Halaman Masuk
            </a>
        </p>
    </form>
@endsection