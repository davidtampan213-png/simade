@extends('layouts.guest-adminlte')
@section('content')
    <h2 class="auth-card-title mb-1">Buat Akun Baru</h2>
    <p class="auth-card-subtitle mb-4">Isi data di bawah untuk mendaftar sebagai Dosen</p>

    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf
        <input type="hidden" name="role" value="dosen">

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus autocomplete="name" class="form-control @error('name') is-invalid @enderror">
            @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required autocomplete="username" class="form-control @error('email') is-invalid @enderror">
            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input id="password" type="password" name="password" placeholder="Min. 8 karakter" required autocomplete="new-password" class="form-control @error('password') is-invalid @enderror">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePass('password', this)" tabindex="-1" aria-label="Tampilkan password"><i id="eyeOpen_password" class="bi bi-eye"></i><i id="eyeClosed_password" class="bi bi-eye-slash d-none"></i></button>
            </div>
            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-group">
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi password Anda" required autocomplete="new-password" class="form-control @error('password_confirmation') is-invalid @enderror">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePass('password_confirmation', this)" tabindex="-1" aria-label="Tampilkan konfirmasi password"><i id="eyeOpen_password_confirmation" class="bi bi-eye"></i><i id="eyeClosed_password_confirmation" class="bi bi-eye-slash d-none"></i></button>
            </div>
            @error('password_confirmation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
        <button type="submit" id="btn-register" class="btn btn-primary w-100 py-2">Daftar</button>
        <p class="text-center small mt-4 mb-0">Sudah punya akun?<a href="{{ route('login') }}" class="fw-semibold ms-1">Masuk di sini</a></p>
    </form>
@endsection
@push('scripts')
<script>
function togglePass(fieldId, btn) {
    const input = document.getElementById(fieldId), eyeOpen = document.getElementById('eyeOpen_' + fieldId), eyeClosed = document.getElementById('eyeClosed_' + fieldId);
    if (input.type === 'password') { input.type = 'text'; eyeOpen.classList.add('d-none'); eyeClosed.classList.remove('d-none'); btn.setAttribute('aria-label', 'Sembunyikan password'); }
    else { input.type = 'password'; eyeOpen.classList.remove('d-none'); eyeClosed.classList.add('d-none'); btn.setAttribute('aria-label', 'Tampilkan password'); }
}
</script>
@endpush