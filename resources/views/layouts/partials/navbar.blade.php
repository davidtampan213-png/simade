<nav class="app-header navbar navbar-expand bg-white border-bottom shadow-sm">
    <div class="container-fluid">
        <!-- Start navbar links -->
        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
                <a class="nav-link text-secondary" data-widget="pushmenu" href="#" role="button" aria-label="Toggle navigasi">
                    <i class="bi bi-list fs-4"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block ms-2">
                <span class="fw-semibold text-dark">
                    Sistem Informasi Manajemen Dosen & Mahasiswa
                </span>
            </li>
        </ul>
        <!-- End navbar links -->

        <!-- Right navbar links -->
        <ul class="navbar-nav ms-auto align-items-center gap-2">
            <!-- Active role indicator badge -->
            <li class="nav-item">
                <span class="badge text-bg-light border text-dark py-2 px-2.5 d-none d-sm-inline-flex align-items-center gap-1">
                    <i class="bi bi-shield-check text-success"></i>
                    <span>Mode: <strong class="text-capitalize">{{ session('active_role', 'mahasiswa') }}</strong></span>
                    <span class="text-muted ms-1">({{ ucfirst(Auth::user()?->role ?? 'User') }})</span>
                </span>
            </li>

            <!-- User Menu Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-center fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                        {{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}
                    </span>
                    <span class="d-none d-md-inline fw-medium text-truncate" style="max-width: 150px;">
                        {{ Auth::user()?->name }}
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2" style="min-width: 220px;">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-semibold text-dark">{{ Auth::user()?->name }}</div>
                        <small class="text-muted text-break">{{ Auth::user()?->email }}</small>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-gear text-secondary"></i> Profil Saya
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('pilih-role') }}">
                            <i class="bi bi-arrow-left-right text-secondary"></i> Ganti Peran (Role)
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 d-flex align-items-center gap-2 text-danger">
                                <i class="bi bi-box-arrow-right"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>