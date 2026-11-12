@php
$activeRole = session('active_role', 'mahasiswa');
$userRole = Auth::user()?->role;
$user = Auth::user();

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

<aside class="app-sidebar bg-white" data-bs-theme="light">
    <!-- User Panel (ala SIMA UNSIQ) -->
    <div class="user-panel px-3 py-3">
        <div class="user-info">
            <img src="{{ asset('logo.png') }}" alt="User Avatar" class="user-avatar">
            <div class="user-details">
                <p class="user-name mb-0">{{ $user->name ?? 'User' }}</p>
                <p class="user-id mb-0">{{ $user->nim ?? $user->nip ?? $user->email ?? 'ID tidak tersedia' }}</p>
            </div>
        </div>
    </div>

    <!-- Menu Navigation -->
    <div class="sidebar-wrapper">
        <nav>
            <ul class="nav sidebar-menu flex-column gap-0 px-2" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                @foreach($mainMenus as $menu)
                    @if($menu['show'])
                        <li class="nav-item">
                            <a href="{{ $menu['url'] }}" class="nav-link rounded d-flex align-items-center gap-2 py-2.5 px-3 {{ $menu['active'] ? 'active' : '' }}">
                                <i class="bi {{ $menu['icon'] }} fs-5"></i>
                                <span class="fw-medium">{{ $menu['title'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
                
                <li class="nav-header px-3 pb-1 pt-3" style="font-size: 0.75rem; font-weight: 600; color: #4b5563; letter-spacing: 0.05em;">
                    PENGATURAN AKUN
                </li>

                @foreach($systemMenus as $menu)
                    @if($menu['show'])
                        <li class="nav-item">
                            <a href="{{ $menu['url'] }}" class="nav-link rounded d-flex align-items-center gap-2 py-2.5 px-3 {{ $menu['active'] ? 'active' : '' }}">
                                <i class="bi {{ $menu['icon'] }} fs-5"></i>
                                <span class="fw-medium">{{ $menu['title'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach

                <li class="nav-item mt-3 pt-2">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="nav-link rounded d-flex align-items-center gap-2 py-2.5 px-3 text-danger w-100 border-0 bg-transparent text-start">
                            <i class="bi bi-box-arrow-right fs-5"></i>
                            <span class="fw-medium">Keluar</span>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
<div class="sidebar-overlay d-md-none" role="presentation"></div>