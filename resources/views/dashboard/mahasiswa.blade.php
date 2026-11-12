<x-adminlte-layout>
    <style>
        .mahasiswa-dashboard .dashboard-title {
            color: #111827;
            font-weight: 700;
        }

        .mahasiswa-dashboard .dashboard-subtitle {
            color: #6B7280;
        }

        .mahasiswa-dashboard .stat-card,
        .mahasiswa-dashboard .chart-card {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
        }

        .mahasiswa-dashboard .stat-card {
            border-top: 3px solid #166534;
            min-height: 164px;
            padding: 24px;
            transition: transform 200ms ease, box-shadow 200ms ease;
        }

        .mahasiswa-dashboard .stat-card:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, .10);
            transform: translateY(-2px);
        }

        .mahasiswa-dashboard .stat-label {
            color: #6B7280;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .mahasiswa-dashboard .stat-value {
            color: #111827;
            font-size: 34px;
            font-weight: 700;
            line-height: 1.15;
        }

        .mahasiswa-dashboard .stat-icon {
            align-items: center;
            background: #F3F4F6;
            border-radius: 10px;
            color: #374151;
            display: inline-flex;
            flex: 0 0 48px;
            font-size: 22px;
            height: 48px;
            justify-content: center;
            width: 48px;
        }

        .mahasiswa-dashboard .stat-detail-link {
            color: #166534;
            display: inline-flex;
            font-size: 13px;
            font-weight: 600;
            gap: 6px;
            text-decoration: none;
        }

        .mahasiswa-dashboard .stat-detail-link:hover {
            color: #14532D;
            text-decoration: underline;
        }

        .mahasiswa-dashboard .chart-card {
            overflow: hidden;
        }

        .mahasiswa-dashboard .chart-card .card-header,
        .mahasiswa-dashboard .chart-card .card-body {
            background: transparent;
        }

        .mahasiswa-dashboard .chart-card .card-title {
            color: #1F2937;
            font-weight: 600;
        }

        @media (prefers-reduced-motion: reduce) {
            .mahasiswa-dashboard .stat-card {
                transition: none;
            }

            .mahasiswa-dashboard .stat-card:hover {
                transform: none;
            }
        }
    </style>

    <x-slot name="header">
        <div class="mahasiswa-dashboard d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3">
            <div>
                <h1 class="dashboard-title h3 mb-0">Dashboard Statistik Mahasiswa</h1>
                <p class="dashboard-subtitle mb-0">Ringkasan data akademik, status keaktifan, dan sebaran fakultas SIMADE</p>
            </div>
            <form method="GET" action="{{ route('dashboard.mahasiswa') }}" class="row g-2 align-items-center">
                <div class="col-sm-auto">
                    <label class="visually-hidden" for="tahun_akademik">Tahun akademik</label>
                    <select id="tahun_akademik" name="tahun_akademik" class="form-select form-select-sm">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunList as $ta)
                            <option value="{{ $ta }}" {{ $tahunAkademik == $ta ? 'selected' : '' }}>{{ $ta }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-auto">
                    <label class="visually-hidden" for="semester">Semester</label>
                    <select id="semester" name="semester" class="form-select form-select-sm">
                        <option value="">Semua Semester</option>
                        @for($s=1; $s<=14; $s++)
                            <option value="{{ $s }}" {{ $semester == $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-sm-auto">
                    <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-funnel"></i> Filter</button>
                </div>
            </form>
        </div>
    </x-slot>

    <div class="mahasiswa-dashboard">
        {{-- Small Boxes (4 stats) ala SIMA UNSIQ --}}
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-lg-3 d-flex">
                <div class="stat-card h-100 w-100 d-flex flex-column">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <p class="stat-label mb-2">Total Mahasiswa</p>
                            <h3 class="stat-value mb-0">{{ number_format($totalMahasiswa) }}</h3>
                        </div>
                        <span class="stat-icon"><i class="bi bi-people"></i></span>
                    </div>
                    <a href="{{ route('mahasiswa.index', array_filter(['tahun_akademik' => $tahunAkademik, 'semester' => $semester])) }}" class="stat-detail-link mt-auto pt-3">
                        Lihat detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 d-flex">
                <div class="stat-card h-100 w-100 d-flex flex-column">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <p class="stat-label mb-2">Mahasiswa Aktif</p>
                            <h3 class="stat-value mb-0">{{ number_format($totalMahasiswaAktif) }}</h3>
                        </div>
                        <span class="stat-icon"><i class="bi bi-person-check"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 d-flex">
                <div class="stat-card h-100 w-100 d-flex flex-column">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <p class="stat-label mb-2">Mahasiswa Nonaktif</p>
                            <h3 class="stat-value mb-0">{{ number_format($totalMahasiswaNonaktif) }}</h3>
                        </div>
                        <span class="stat-icon"><i class="bi bi-person-x"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 d-flex">
                <div class="stat-card h-100 w-100 d-flex flex-column">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <p class="stat-label mb-2">Mahasiswa Cuti</p>
                            <h3 class="stat-value mb-0">{{ number_format($totalMahasiswaCuti) }}</h3>
                        </div>
                        <span class="stat-icon"><i class="bi bi-calendar-minus"></i></span>
                    </div>
                </div>
            </div>
        </div>

    {{-- Grafik Sebaran per Program Studi dan Fakultas --}}
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="chart-card h-100">
                <div class="card-header border-0">
                    <h3 class="card-title mb-0">Sebaran per Program Studi</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative" style="height: 280px;">
                        <canvas id="jurusanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="chart-card h-100">
                <div class="card-header border-0">
                    <h3 class="card-title mb-0">Sebaran per Fakultas</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative" style="height: 280px;">
                        <canvas id="fakultasChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart Jurusan/Program Studi
            const jurusanCanvas = document.getElementById('jurusanChart');
            if (jurusanCanvas) {
                const jurusanData = @json($mahasiswaPerJurusan);
                new Chart(jurusanCanvas.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: jurusanData.map(item => item.label || 'Unknown'),
                        datasets: [{
                            label: 'Jumlah Mahasiswa',
                            data: jurusanData.map(item => item.total),
                            backgroundColor: '#166534',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, color: '#4B5563', font: { size: 11 } },
                                grid: { color: '#F3F4F6', borderColor: '#F3F4F6' },
                                border: { color: '#4B5563' }
                            },
                            x: {
                                ticks: { color: '#4B5563', font: { size: 11 } },
                                grid: { display: false },
                                border: { color: '#4B5563' }
                            }
                        }
                    }
                });
            }

            // Chart Fakultas
            const fakultasCanvas = document.getElementById('fakultasChart');
            if (fakultasCanvas) {
                const fakultasData = @json($mahasiswaPerFakultas);
                const calmPalette = [
                    '#166534',
                    '#3F7E8C',
                    '#A16207',
                    '#A65A52',
                    '#5F6F99',
                    '#3C8079'
                ];
                new Chart(fakultasCanvas.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: fakultasData.map(item => item.fakultas),
                        datasets: [{
                            data: fakultasData.map(item => item.total),
                            backgroundColor: calmPalette,
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#4B5563',
                                    font: { size: 12 },
                                    boxWidth: 12,
                                    padding: 16
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</div>
</x-adminlte-layout>
