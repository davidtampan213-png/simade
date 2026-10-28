@extends('layouts.guest-adminlte')
@section('content')
    <h2 class="auth-card-title mb-1">Konfirmasi Akses</h2>
    <p class="auth-card-subtitle mb-4">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </p>

    <form method="POST" action="{{ route('password.confirm') }}" novalidate>
        @csrf

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="form-control @error('password') is-invalid @enderror"
            >
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">
            {{ __('Confirm') }}
        </button>
    </form>
@endsection