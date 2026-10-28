@php
$activeRole = session('active_role', 'mahasiswa');
$userRole = Auth::user()?->role;

// Menu dari satu sumber data (array terstruktur)
$mainMenus = [];

if ($activeRole === 'dosen') {
    $mainMenus[] = [
        'title' => 'Dashboard Dosen',
        'url' => route('dashboard.dosen'),
        'icon' => 'bi-speedometer2',
        'active' => request()->routeIs('dashboard.dosen'),
        'show' => true,
    ];
    if ($userRole === 'admin') {
        $mainMenus[] = [
            'title' => 'Data Dosen',
            'url' => route('dosen.index'),
            'icon' => 'bi-person-badge',
            'active' => request()->routeIs('dosen.*'),
            'show' => true,
        ];
    }
} else {
    // Mode mahasiswa
    $mainMenus[] = [
        'title' => 'Dashboard Mahasiswa',
        'url' => route('dashboard.mahasiswa'),
        'icon' => 'bi-speedometer2',
        'active' => request()->routeIs('dashboard.mahasiswa'),
        'show' => true,
    ];
    if (in_array($userRole, ['admin', 'dosen'])) {
        $mainMenus[] = [
            'title' => 'Data Mahasiswa',
            'url' => route('mahasiswa.index'),
            'icon' => 'bi-people',
            'active' => request()->routeIs('mahasiswa.*') && !request()->routeIs('mahasiswa.laporan*'),
            'show' => true,
        ];
        $mainMenus[] = [
            'title' => 'Laporan Mahasiswa',
            'url' => route('mahasiswa.laporan'),
            'icon' => 'bi-file-earmark-bar-graph',
            'active' => request()->routeIs('mahasiswa.laporan*'),
            'show' => true,
        ];
    }
}

$systemMenus = [
    [
        'title' => 'Ganti Peran (Role)',
        'url' => route('pilih-role'),
        'icon' => 'bi-arrow-left-right',
        'active' => request()->routeIs('pilih-role'),
        'show' => true,
    ],
    [
        'title' => 'Profil Pengguna',
        'url' => route('profile.edit'),
        'icon' => 'bi-person-gear',
        'active' => request()->routeIs('profile.*'),
        'show' => true,
    ],
];
@endphp

<aside class="app-sidebar bg-white shadow-sm" data-bs-theme="light">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand border-bottom px-3 py-2.5 d-flex align-items-center justify-content-between">
        <a href="{{ $activeRole === 'dosen' ? route('dashboard.dosen') : route('dashboard.mahasiswa') }}" class="brand-link d-flex align-items-center text-decoration-none text-dark gap-2">
            <img src="{{ asset('logo.png') }}" alt="Logo UNSIQ" class="brand-image img-fluid" style="height: 38px; width: auto; max-width: 45px; object-fit: contain;">
            <div class="d-flex flex-column lh-1">
                <span class="brand-text fw-bold fs-5 tracking-wide text-dark">SIMADE</span>
                <small class="text-secondary" style="font-size: 0.72rem; letter-spacing: 0.03em;">PORTAL AKADEMIK</small>
            </div>
        </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper py-2">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column gap-1 px-2" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <li class="nav-header text-uppercase px-3 pt-2 pb-1" style="font-size: 0.72rem; font-weight: 600; letter-spacing: 0.05em;">
                    Menu Utama ({{ ucfirst($activeRole) }})
                </li>

                @foreach($mainMenus as $menu)
                    @if($menu['show'])
                        <li class="nav-item">
                            <a href="{{ $menu['url'] }}" class="nav-link rounded-1 d-flex align-items-center gap-2 py-2 px-3 {{ $menu['active'] ? 'active' : '' }}">
                                <i class="bi {{ $menu['icon'] }} fs-5"></i>
                                <span class="fs-6">{{ $menu['title'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach

                <li class="nav-header text-uppercase text-white-50 px-3 pt-3 pb-1" style="font-size: 0.72rem; font-weight: 600; letter-spacing: 0.05em;">
                    Pengaturan Akun
                </li>

                @foreach($systemMenus as $menu)
                    @if($menu['show'])
                        <li class="nav-item">
                            <a href="{{ $menu['url'] }}" class="nav-link rounded-1 d-flex align-items-center gap-2 py-2 px-3 {{ $menu['active'] ? 'active' : '' }}">
                                <i class="bi {{ $menu['icon'] }} fs-5"></i>
                                <span class="fs-6">{{ $menu['title'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach

                <li class="nav-item mt-2 pt-2 border-top">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="nav-link rounded-1 d-flex align-items-center gap-2 py-2 px-3 text-danger w-100 border-0 bg-transparent text-start">
                            <i class="bi bi-box-arrow-right fs-5"></i>
                            <span class="fs-6">Keluar Sistem</span>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
<div class="sidebar-overlay d-md-none" role="presentation"></div>
