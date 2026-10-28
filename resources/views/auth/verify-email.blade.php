@extends('layouts.guest-adminlte')
@section('content')
    <h2 class="auth-card-title mb-1">Verifikasi Email</h2>
    <p class="auth-card-subtitle mb-4">
        Terima kasih telah mendaftar. Sebelum melanjutkan, verifikasi alamat email Anda melalui tautan yang telah kami kirimkan. Jika belum menerima email, kami dapat mengirimkannya kembali.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" role="alert">
            Tautan verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat pendaftaran.
        </div>
    @endif

    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Kirim Ulang Email Verifikasi</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 text-decoration-none">Keluar</button>
        </form>
    </div>
@endsection