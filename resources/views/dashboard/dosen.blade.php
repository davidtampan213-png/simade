<x-adminlte-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 text-dark fw-semibold">Dashboard Statistik Dosen</h1>
                <p class="text-body-secondary small mb-0">Ringkasan profil, penelitian, pembelajaran, dan kinerja dosen SIMADE</p>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-start gap-2" role="alert">
            <i class="bi bi-check-circle-fill mt-1"></i>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Row 1: Stat Cards (Small Box AdminLTE) --}}
    <div class="row g-3 mb-4">
        <!-- Total Dosen -->
        <div class="col-12 col-sm-6 col-lg-4">
            @if(Auth::user()->isAdmin())
                <a href="{{ route('dosen.index') }}" class="text-decoration-none">
            @endif
            <div class="small-box text-bg-primary h-100">
                <div class="inner">
                    <p class="mb-1">Total Dosen</p>
                    <h3 class="fw-bold">{{ $totalDosen }}</h3>
                    <small>Dosen terdaftar di sistem</small>
                </div>
                <div class="icon">
                    <i class="bi bi-briefcase"></i>
                </div>
                @if(Auth::user()->isAdmin())
                    <span class="small-box-footer">Lihat Detail <i class="bi bi-arrow-right"></i></span>
                @else
                    <div class="small-box-footer">&nbsp;</div>
                @endif
            </div>
            @if(Auth::user()->isAdmin())
                </a>
            @endif
        </div>

        <!-- Dosen Aktif -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="small-box text-bg-success h-100">
                <div class="inner">
                    <p class="mb-1">Dosen Aktif</p>
                    <h3 class="fw-bold">{{ $totalDosenAktif }}</h3>
                    <small>Status aktif bertugas</small>
                </div>
                <div class="icon">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="small-box-footer">&nbsp;</div>
            </div>
        </div>

        <!-- Dosen Nonaktif -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="small-box text-bg-danger h-100">
                <div class="inner">
                    <p class="mb-1">Dosen Nonaktif</p>
                    <h3 class="fw-bold">{{ $totalDosenNonaktif }}</h3>
                    <small>Status tidak aktif</small>
                </div>
                <div class="icon">
                    <i class="bi bi-person-x"></i>
                </div>
                <div class="small-box-footer">&nbsp;</div>
            </div>
        </div>

        <!-- Total Penelitian -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="small-box text-bg-info h-100">
                <div class="inner">
                    <p class="mb-1">Total Penelitian</p>
                    <h3 class="fw-bold">{{ $totalPenelitian }}</h3>
                    <small>Publikasi dan riset tercatat</small>
                </div>
                <div class="icon">
                    <i class="bi bi-lightbulb"></i>
                </div>
                <div class="small-box-footer">&nbsp;</div>
            </div>
        </div>

        <!-- Total Mata Kuliah -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="small-box text-bg-warning h-100">
                <div class="inner">
                    <p class="mb-1">Total Mata Kuliah</p>
                    <h3 class="fw-bold">{{ $totalPembelajaran }}</h3>
                    <small>{{ $totalSks }} SKS total</small>
                </div>
                <div class="icon">
                    <i class="bi bi-book"></i>
                </div>
                <div class="small-box-footer">&nbsp;</div>
            </div>
        </div>

        <!-- Kinerja Sangat Baik -->
        @php
            $kinerjaMap = $kinerjaPerKategori->keyBy('kategori');
            $totalKinerja = $kinerjaPerKategori->sum('total');
            $sangatBaik = $kinerjaMap->get('Sangat Baik')?->total ?? 0;
        @endphp
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="small-box text-bg-secondary h-100">
                <div class="inner">
                    <p class="mb-1">Kinerja Sangat Baik</p>
                    <h3 class="fw-bold">{{ $sangatBaik }}</h3>
                    <small>dari {{ $totalKinerja }} penilaian</small>
                </div>
                <div class="icon">
                    <i class="bi bi-award"></i>
                </div>
                <div class="small-box-footer">&nbsp;</div>
            </div>
        </div>
    </div>

    {{-- Row 2: Charts --}}
    <div class="row g-4 mb-4">
        <!-- Dosen per Jurusan (Pie) -->
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0">
                    <h3 class="card-title mb-0">Dosen per Jurusan</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative" style="height: 280px;">
                        <canvas id="dosenJurusanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dosen per Jabatan (Bar Horizontal) -->
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0">
                    <h3 class="card-title mb-0">Dosen per Jabatan</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative" style="height: 280px;">
                        <canvas id="dosenJabatanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kinerja per Kategori (Doughnut) -->
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0">
                    <h3 class="card-title mb-0">Distribusi Kinerja Dosen</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative" style="height: 280px;">
                        <canvas id="kinerjaKategoriChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dosen per Status (Bar) -->
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0">
                    <h3 class="card-title mb-0">Dosen per Status</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative" style="height: 280px;">
                        <canvas id="dosenStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.register(ChartDataLabels);

            const distinctBgColors = [
                'rgba(16, 185, 129, 0.85)',
                'rgba(59, 130, 246, 0.85)',
                'rgba(139, 92, 246, 0.85)',
                'rgba(245, 158, 11, 0.85)',
                'rgba(236, 72, 153, 0.85)',
                'rgba(14, 165, 233, 0.85)',
                'rgba(239, 68, 68, 0.85)',
            ];

            // --- Dosen Jurusan Chart (Pie) ---
            const dosenJurusanDataRaw = @json($dosenPerJurusan);
            new Chart(document.getElementById('dosenJurusanChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: dosenJurusanDataRaw.map(i => i.jurusan || 'Unknown'),
                    datasets: [{ data: dosenJurusanDataRaw.map(i => i.total), backgroundColor: distinctBgColors, borderWidth: 1 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        datalabels: {
                            color: '#fff', font: { weight: 'bold', size: 12 },
                            formatter: (value, ctx) => {
                                let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => Number(a) + Number(b), 0);
                                return sum > 0 ? (value * 100 / sum).toFixed(1) + '%' : '';
                            }
                        }
                    }
                }
            });

            // --- Dosen Jabatan Chart (Horizontal Bar) ---
            const dosenJabatanDataRaw = @json($dosenPerJabatan);
            new Chart(document.getElementById('dosenJabatanChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: dosenJabatanDataRaw.map(i => i.jabatan || '-'),
                    datasets: [{
                        label: 'Jumlah',
                        data: dosenJabatanDataRaw.map(i => i.total),
                        backgroundColor: 'rgba(5, 150, 105, 0.85)',
                        borderColor: '#047857',
                        borderWidth: 1, borderRadius: 4
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true, maintainAspectRatio: false,
                    scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } },
                    plugins: {
                        legend: { display: false },
                        datalabels: { color: '#047857', anchor: 'end', align: 'right', font: { weight: 'bold' } }
                    }
                }
            });

            // --- Kinerja per Kategori (Doughnut) ---
            const kinerjaDataRaw = @json($kinerjaPerKategori);
            const kinerjaColors = {
                'Sangat Baik': 'rgba(16, 185, 129, 0.85)',
                'Baik':        'rgba(59, 130, 246, 0.85)',
                'Cukup':       'rgba(245, 158, 11, 0.85)',
                'Kurang':      'rgba(239, 68, 68, 0.85)',
            };
            new Chart(document.getElementById('kinerjaKategoriChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: kinerjaDataRaw.map(i => i.kategori),
                    datasets: [{
                        data: kinerjaDataRaw.map(i => i.total),
                        backgroundColor: kinerjaDataRaw.map(i => kinerjaColors[i.kategori] || 'rgba(107,114,128,0.85)'),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        datalabels: {
                            color: '#fff', font: { weight: 'bold', size: 12 },
                            formatter: (value, ctx) => {
                                let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => Number(a) + Number(b), 0);
                                return sum > 0 ? (value * 100 / sum).toFixed(1) + '%' : '';
                            }
                        }
                    }
                }
            });

            // --- Dosen Status Chart (Bar) ---
            const dosenStatusDataRaw = @json($dosenPerStatus);
            const statusColors = dosenStatusDataRaw.map(i => i.status === 'Aktif' ? 'rgba(16,185,129,0.85)' : 'rgba(239,68,68,0.85)');
            new Chart(document.getElementById('dosenStatusChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: dosenStatusDataRaw.map(i => i.status),
                    datasets: [{
                        label: 'Jumlah Dosen',
                        data: dosenStatusDataRaw.map(i => i.total),
                        backgroundColor: statusColors, borderWidth: 1, borderRadius: 4
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
                    plugins: {
                        legend: { display: false },
                        datalabels: { anchor: 'end', align: 'top', font: { weight: 'bold' }, formatter: v => v }
                    }
                }
            });
        });
    </script>
    @endpush
</x-adminlte-layout>
