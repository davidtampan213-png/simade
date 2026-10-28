@extends('layouts.guest-adminlte')
@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <h2 class="auth-card-title mb-1">Selamat Datang</h2>
    <p class="auth-card-subtitle mb-4">Masukkan kredensial Anda untuk mengakses sistem</p>

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                placeholder="contoh@email.com"
                required
                autofocus
                autocomplete="username"
                class="form-control @error('email') is-invalid @enderror"
            >
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                    class="form-control @error('password') is-invalid @enderror"
                >
                <button
                    type="button"
                    id="togglePassword"
                    class="btn btn-outline-secondary"
                    onclick="togglePass('password', this)"
                    aria-label="Tampilkan password"
                    tabindex="-1"
                >
                    <i id="eyeOpen_password" class="bi bi-eye"></i>
                    <i id="eyeClosed_password" class="bi bi-eye-slash d-none"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input
                    type="checkbox"
                    name="remember"
                    id="remember_me"
                    class="form-check-input"
                >
                <label for="remember_me" class="form-check-label">Ingat saya</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small">
                    Lupa password?
                </a>
            @endif
        </div>

        {{-- Tombol Masuk --}}
        <button
            type="submit"
            id="btn-login"
            class="btn btn-primary w-100 py-2"
        >
            Masuk
        </button>

        {{-- Link Daftar --}}
        @if (Route::has('register'))
            <p class="text-center small mt-4 mb-0">
                Belum punya akun?
                <a href="{{ route('register') }}" class="fw-semibold ms-1">
                    Daftar di sini
                </a>
            </p>
        @endif
    </form>
@endsection

@push('scripts')
<script>
function togglePass(fieldId, btn) {
    const input     = document.getElementById(fieldId);
    const eyeOpen   = document.getElementById('eyeOpen_' + fieldId);
    const eyeClosed = document.getElementById('eyeClosed_' + fieldId);
    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.classList.add('d-none');
        eyeClosed.classList.remove('d-none');
        btn.setAttribute('aria-label', 'Sembunyikan password');
    } else {
        input.type = 'password';
        eyeOpen.classList.remove('d-none');
        eyeClosed.classList.add('d-none');
        btn.setAttribute('aria-label', 'Tampilkan password');
    }
}
</script>
@endpush