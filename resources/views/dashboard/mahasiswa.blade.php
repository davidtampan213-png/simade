<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            {{-- Judul Halaman --}}
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Dashboard Statistik Mahasiswa
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Ringkasan data akademik, status keaktifan, dan sebaran fakultas SIMADE
                </p>
            </div>

            {{-- Filter Bar Sejajar --}}
            <form method="GET" action="{{ route('dashboard.mahasiswa') }}" class="flex flex-wrap items-center gap-2.5">
                {{-- Filter Tahun Akademik --}}
                <div class="relative">
                    <select name="tahun_akademik"
                            class="text-xs sm:text-sm rounded-xl border-gray-200 bg-white py-2 pl-3 pr-8 shadow-sm hover:border-emerald-400 focus:border-emerald-500 focus:ring-emerald-500 text-gray-700 font-medium transition cursor-pointer">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunList as $ta)
                            <option value="{{ $ta }}" {{ $tahunAkademik == $ta ? 'selected' : '' }}>
                                T.A. {{ $ta }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Semester --}}
                <div class="relative">
                    <select name="semester"
                            class="text-xs sm:text-sm rounded-xl border-gray-200 bg-white py-2 pl-3 pr-8 shadow-sm hover:border-emerald-400 focus:border-emerald-500 focus:ring-emerald-500 text-gray-700 font-medium transition cursor-pointer">
                        <option value="">Semua Semester</option>
                        @for($s = 1; $s <= 14; $s++)
                            <option value="{{ $s }}" {{ $semester == $s ? 'selected' : '' }}>
                                Semester {{ $s }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Tombol Filter --}}
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm hover:shadow transition duration-150 ease-in-out cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>

                {{-- Tombol Reset --}}
                <a href="{{ route('dashboard.mahasiswa') }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gray-100 hover:bg-gray-200 active:bg-gray-300 text-gray-600 text-xs sm:text-sm font-medium rounded-xl transition duration-150 ease-in-out cursor-pointer"
                   title="Reset filter">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset
                </a>
            </form>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ===== NOTIFIKASI SUKSES / FILTER AKTIF ===== --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-2.5 rounded-xl text-xs sm:text-sm flex items-center justify-between shadow-xs" role="alert">
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm font-bold ml-3 cursor-pointer">✕</button>
                </div>
            @endif

            @if($tahunAkademik || $semester)
                <div class="bg-white border border-emerald-100 rounded-xl px-4 py-2.5 text-xs sm:text-sm text-gray-700 flex flex-wrap items-center justify-between gap-2 shadow-xs">
                    <div class="flex items-center gap-2 text-gray-600">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Menampilkan periode:</span>
                        @if($tahunAkademik)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-semibold text-xs border border-emerald-200">
                                T.A. {{ $tahunAkademik }}
                            </span>
                        @endif
                        @if($semester)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-semibold text-xs border border-emerald-200">
                                Semester {{ $semester }}
                            </span>
                        @endif
                    </div>
                    <a href="{{ route('dashboard.mahasiswa') }}" class="text-xs text-emerald-600 hover:text-emerald-800 hover:underline font-semibold flex items-center gap-1">
                        Hapus filter ×
                    </a>
                </div>
            @endif

            {{-- ===== 4 KARTU STATISTIK MODERN ===== --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                {{-- 1. Total Mahasiswa --}}
                <a href="{{ route('mahasiswa.index', array_filter(['tahun_akademik' => $tahunAkademik, 'semester' => $semester])) }}"
                   class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 p-5 sm:p-6 flex flex-col justify-between relative overflow-hidden">
                    <div class="h-1 w-full bg-emerald-800 absolute top-0 left-0"></div>
                    <div>
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 block mb-1">
                                    Total Mahasiswa
                                </span>
                                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                                    {{ number_format($totalMahasiswa) }}
                                </h2>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-800 group-hover:scale-105 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            Keseluruhan mahasiswa terdaftar
                        </p>
                    </div>
                    <div class="border-t border-gray-100 pt-3.5 mt-4 flex items-center justify-between text-xs font-semibold text-emerald-800 group-hover:text-emerald-950">
                        <span>Lihat semua mahasiswa</span>
                        <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>

                {{-- 2. Mahasiswa Aktif --}}
                <a href="{{ route('mahasiswa.index', array_filter(['status' => 'Aktif', 'tahun_akademik' => $tahunAkademik, 'semester' => $semester])) }}"
                   class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 p-5 sm:p-6 flex flex-col justify-between relative overflow-hidden">
                    <div class="h-1 w-full bg-emerald-500 absolute top-0 left-0"></div>
                    <div>
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-700 block mb-1">
                                    Mahasiswa Aktif
                                </span>
                                <h2 class="text-3xl sm:text-4xl font-extrabold text-emerald-600 tracking-tight">
                                    {{ number_format($totalMahasiswaAktif) }}
                                </h2>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-105 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-emerald-700/80 mt-2">
                            @if($totalMahasiswa > 0)
                                {{ round(($totalMahasiswaAktif / $totalMahasiswa) * 100) }}% dari total mahasiswa
                            @else
                                0% dari total mahasiswa
                            @endif
                        </p>
                    </div>
                    <div class="border-t border-gray-100 pt-3.5 mt-4 flex items-center justify-between text-xs font-semibold text-emerald-600 group-hover:text-emerald-800">
                        <span>Lihat mahasiswa aktif</span>
                        <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>

                {{-- 3. Mahasiswa Nonaktif --}}
                <a href="{{ route('mahasiswa.index', array_filter(['status' => 'Nonaktif', 'tahun_akademik' => $tahunAkademik, 'semester' => $semester])) }}"
                   class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 p-5 sm:p-6 flex flex-col justify-between relative overflow-hidden">
                    <div class="h-1 w-full bg-rose-500 absolute top-0 left-0"></div>
                    <div>
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-rose-700 block mb-1">
                                    Mahasiswa Nonaktif
                                </span>
                                <h2 class="text-3xl sm:text-4xl font-extrabold text-rose-600 tracking-tight">
                                    {{ number_format($totalMahasiswaNonaktif) }}
                                </h2>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 group-hover:scale-105 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-rose-700/80 mt-2">
                            @if($totalMahasiswa > 0)
                                {{ round(($totalMahasiswaNonaktif / $totalMahasiswa) * 100) }}% dari total mahasiswa
                            @else
                                0% dari total mahasiswa
                            @endif
                        </p>
                    </div>
                    <div class="border-t border-gray-100 pt-3.5 mt-4 flex items-center justify-between text-xs font-semibold text-rose-600 group-hover:text-rose-800">
                        <span>Lihat mahasiswa nonaktif</span>
                        <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>

                {{-- 4. Mahasiswa Cuti --}}
                <a href="{{ route('mahasiswa.index', array_filter(['status' => 'Cuti', 'tahun_akademik' => $tahunAkademik, 'semester' => $semester])) }}"
                   class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 p-5 sm:p-6 flex flex-col justify-between relative overflow-hidden">
                    <div class="h-1 w-full bg-amber-500 absolute top-0 left-0"></div>
                    <div>
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-amber-700 block mb-1">
                                    Mahasiswa Cuti
                                </span>
                                <h2 class="text-3xl sm:text-4xl font-extrabold text-amber-600 tracking-tight">
                                    {{ number_format($totalMahasiswaCuti) }}
                                </h2>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 group-hover:scale-105 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-amber-700/80 mt-2">
                            @if($totalMahasiswa > 0)
                                {{ round(($totalMahasiswaCuti / $totalMahasiswa) * 100) }}% dari total mahasiswa
                            @else
                                0% dari total mahasiswa
                            @endif
                        </p>
                    </div>
                    <div class="border-t border-gray-100 pt-3.5 mt-4 flex items-center justify-between text-xs font-semibold text-amber-600 group-hover:text-amber-800">
                        <span>Lihat mahasiswa cuti</span>
                        <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>
            </div>

            {{-- ===== BAGIAN GRAFIK & RINCIAN DUA KOLOM ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Donut Chart: Distribusi Status Mahasiswa --}}
                <div class="lg:col-span-5 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-800">Distribusi Status Mahasiswa</h3>
                                    <p class="text-xs text-gray-400">Proporsi aktif, nonaktif, dan cuti</p>
                                </div>
                            </div>
                        </div>

                        <div class="relative h-56 flex items-center justify-center">
                            @if($totalMahasiswa > 0)
                                <canvas id="statusChart"></canvas>
                            @else
                                <p class="text-xs text-gray-400 italic">Tidak ada data status untuk ditampilkan</p>
                            @endif
                        </div>
                    </div>

                    {{-- Legend Pills --}}
                    <div class="grid grid-cols-3 gap-2 border-t border-gray-100 pt-4 mt-4 text-center">
                        <div class="bg-emerald-50/70 rounded-xl p-2.5">
                            <span class="text-[11px] text-gray-500 font-medium block">Aktif</span>
                            <span class="text-sm font-bold text-emerald-700">{{ $totalMahasiswaAktif }}</span>
                        </div>
                        <div class="bg-rose-50/70 rounded-xl p-2.5">
                            <span class="text-[11px] text-gray-500 font-medium block">Nonaktif</span>
                            <span class="text-sm font-bold text-rose-700">{{ $totalMahasiswaNonaktif }}</span>
                        </div>
                        <div class="bg-amber-50/70 rounded-xl p-2.5">
                            <span class="text-[11px] text-gray-500 font-medium block">Cuti</span>
                            <span class="text-sm font-bold text-amber-700">{{ $totalMahasiswaCuti }}</span>
                        </div>
                    </div>
                </div>

                {{-- Bar Chart: Sebaran per Program Studi --}}
                <div class="lg:col-span-7 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-800">Mahasiswa per Program Studi</h3>
                                    <p class="text-xs text-gray-400">Peringkat jumlah mahasiswa terbanyak</p>
                                </div>
                            </div>
                        </div>

                        <div class="relative h-64">
                            @if($mahasiswaPerJurusan->count() > 0)
                                <canvas id="prodiChart"></canvas>
                            @else
                                <div class="h-full flex items-center justify-center">
                                    <p class="text-xs text-gray-400 italic">Belum ada data program studi</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-3 mt-3 flex items-center justify-between text-xs text-gray-500">
                        <span>Total {{ $mahasiswaPerJurusan->count() }} program studi terdaftar</span>
                        <a href="{{ route('mahasiswa.laporan') }}" class="text-emerald-700 hover:text-emerald-900 font-semibold hover:underline">
                            Lihat rincian lengkap →
                        </a>
                    </div>
                </div>
            </div>

            {{-- ===== TABEL STATISTIK FAKULTAS ===== --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-sm font-bold text-gray-800">Statistik Mahasiswa per Fakultas</h3>
                            <p class="text-xs text-gray-400">Klik tombol detail untuk melihat rincian per program studi</p>
                        </div>
                    </div>
                    <a href="{{ route('mahasiswa.laporan') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 hover:text-emerald-900 hover:underline">
                        <span>Buka Halaman Laporan</span>
                        <span>→</span>
                    </a>
                </div>

                @if($mahasiswaPerFakultas->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 text-sm">
                            <thead class="bg-emerald-50/70 text-emerald-900">
                                <tr>
                                    <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider">Fakultas</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider">Total</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider">Aktif</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider">Nonaktif</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider">Cuti</th>
                                    <th class="px-6 py-3.5 text-center text-xs font-bold uppercase tracking-wider">Tingkat Keaktifan</th>
                                    <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach($mahasiswaPerFakultas as $f)
                                @php
                                    $fTotal = $f->total ?: 0;
                                    $fAktif = $f->aktif ?: 0;
                                    $fNonaktif = $f->nonaktif ?: 0;
                                    $fCuti = $f->cuti ?: 0;
                                    $persenAktif = $fTotal > 0 ? round(($fAktif / $fTotal) * 100) : 0;
                                @endphp
                                <tr class="hover:bg-emerald-50/20 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-gray-800 whitespace-nowrap">
                                        {{ $f->fakultas }}
                                    </td>
                                    <td class="px-5 py-4 text-center font-bold text-gray-900 whitespace-nowrap">
                                        {{ number_format($fTotal) }}
                                    </td>
                                    <td class="px-5 py-4 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                            {{ $fAktif }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/60">
                                            {{ $fNonaktif }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
                                            {{ $fCuti }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <div class="w-24 bg-gray-100 rounded-full h-2 overflow-hidden">
                                                <div class="bg-emerald-500 h-2 rounded-full transition-all duration-300" style="width: {{ $persenAktif }}%"></div>
                                            </div>
                                            <span class="text-xs font-semibold text-gray-600 w-10 text-right">{{ $persenAktif }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-center whitespace-nowrap">
                                        <a href="{{ route('mahasiswa.laporan.fakultas', $f->fakultas) }}?tahun_akademik={{ $tahunAkademik }}&semester={{ $semester }}"
                                           class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 hover:text-emerald-800 rounded-lg text-xs font-semibold transition cursor-pointer">
                                            Detail →
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-10 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-400 text-sm">Tidak ada data fakultas pada periode yang dipilih.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Script Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Donut Chart Status
        const statusCanvas = document.getElementById('statusChart');
        if (statusCanvas) {
            const statusLabels = ['Aktif', 'Nonaktif', 'Cuti'];
            const statusData   = [{{ $totalMahasiswaAktif }}, {{ $totalMahasiswaNonaktif }}, {{ $totalMahasiswaCuti }}];
            new Chart(statusCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.9)', // Emerald green
                            'rgba(244, 63, 94, 0.85)',  // Soft Rose
                            'rgba(245, 158, 11, 0.85)'   // Amber
                        ],
                        hoverBackgroundColor: [
                            '#059669',
                            '#e11d48',
                            '#d97706'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = statusData.reduce((a, b) => a + b, 0);
                                    const val = context.raw || 0;
                                    const pct = total > 0 ? Math.round((val / total) * 100) : 0;
                                    return ` ${context.label}: ${val} mahasiswa (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // 2. Bar Chart Program Studi
        const prodiCanvas = document.getElementById('prodiChart');
        if (prodiCanvas) {
            const prodiData = @json($mahasiswaPerJurusan);
            const labels = prodiData.map(item => item.label);
            const totals = prodiData.map(item => item.total);

            new Chart(prodiCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Mahasiswa',
                        data: totals,
                        backgroundColor: 'rgba(5, 150, 105, 0.85)',
                        hoverBackgroundColor: '#047857',
                        borderRadius: 6,
                        maxBarThickness: 32,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ` ${context.parsed.y} Mahasiswa`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: { size: 11 }
                            },
                            grid: {
                                color: 'rgba(243, 244, 246, 1)'
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 11 },
                                maxRotation: 30,
                                minRotation: 0
                            },
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    });
    </script>
</x-app-layout>
