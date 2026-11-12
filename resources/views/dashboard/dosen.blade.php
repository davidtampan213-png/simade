<x-adminlte-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 text-dark fw-semibold">Dashboard Statistik Dosen</h1>
                <p class="small mb-0 text-secondary fw-medium">Ringkasan profil, penelitian, pembelajaran, dan kinerja dosen SIMADE</p>
            </div>
        </div>
    </x-slot>

    {{-- Row 1: Compact Stats (x-small-box) --}}
    <div class="row g-3 mb-4" style="height: auto;">
        <!-- Total Dosen -->
        <div class="col-12 col-sm-6 col-lg-4">
            <x-x-small-box 
                title="Total Dosen" 
                :value="$totalDosen" 
                subtitle="Dosen terdaftar di sistem"
                icon="bi bi-briefcase"
                variant="primary"
                :url="Auth::user()->isAdmin() ? route('dosen.index') : null"
                linkText="Lihat Detail"
            />
        </div>

        <!-- Dosen Aktif -->
        <div class="col-12 col-sm-6 col-lg-4">
            <x-x-small-box 
                title="Dosen Aktif" 
                :value="$totalDosenAktif" 
                subtitle="Status aktif bertugas"
                icon="bi bi-person-check"
                variant="success"
            />
        </div>

        <!-- Dosen Nonaktif -->
        <div class="col-12 col-sm-6 col-lg-4">
            <x-x-small-box 
                title="Dosen Nonaktif" 
                :value="$totalDosenNonaktif" 
                subtitle="Status tidak aktif"
                icon="bi bi-person-x"
                variant="danger"
            />
        </div>

        <!-- Total Penelitian -->
        <div class="col-12 col-sm-6 col-lg-4">
            <x-x-small-box 
                title="Total Penelitian" 
                :value="$totalPenelitian" 
                subtitle="Publikasi dan riset tercatat"
                icon="bi bi-lightbulb"
                variant="info"
            />
        </div>

        <!-- Total Mata Kuliah -->
        <div class="col-12 col-sm-6 col-lg-4">
            <x-x-small-box 
                title="Total Mata Kuliah" 
                :value="$totalPembelajaran" 
                :subtitle="$totalSks . ' SKS total'"
                icon="bi bi-book"
                variant="warning"
            />
        </div>

        <!-- Kinerja Sangat Baik -->
        @php
            $kinerjaMap = $kinerjaPerKategori->keyBy('kategori');
            $totalKinerja = $kinerjaPerKategori->sum('total');
            $sangatBaik = $kinerjaMap->get('Sangat Baik')?->total ?? 0;
        @endphp
        <div class="col-12 col-sm-6 col-lg-4">
            <x-x-small-box 
                title="Kinerja Sangat Baik" 
                :value="$sangatBaik" 
                :subtitle="'dari ' . $totalKinerja . ' penilaian'"
                icon="bi bi-award"
                variant="success"
            />
        </div>
    </div>

    {{-- Row 2: Charts --}}
    <style>
        .dosen-chart-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
            overflow: hidden;
        }
        .dosen-chart-card .card-header {
            padding: 16px 20px 12px;
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
        }
        .dosen-chart-card .card-title {
            color: #1f2937;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.4;
        }
        .dosen-chart-card .card-body {
            padding: 16px 20px 20px;
        }
        .dosen-chart-canvas {
            height: 240px;
        }
    </style>
    <div class="row g-3 mb-4">
        <!-- Dosen per Jurusan (Pie) -->
        <div class="col-12 col-lg-6">
            <div class="card dosen-chart-card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-0">Dosen per Jurusan</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative dosen-chart-canvas">
                        <canvas id="dosenJurusanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dosen per Jabatan (Bar Horizontal) -->
        <div class="col-12 col-lg-6">
            <div class="card dosen-chart-card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-0">Dosen per Jabatan</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative dosen-chart-canvas">
                        <canvas id="dosenJabatanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kinerja per Kategori (Doughnut) -->
        <div class="col-12 col-lg-6">
            <div class="card dosen-chart-card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-0">Distribusi Kinerja Dosen</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative dosen-chart-canvas">
                        <canvas id="kinerjaKategoriChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dosen per Status (Bar) -->
        <div class="col-12 col-lg-6">
            <div class="card dosen-chart-card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-0">Dosen per Status</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative dosen-chart-canvas">
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

            Chart.defaults.font.family = 'Inter, sans-serif';
            Chart.defaults.font.size = 12;
            Chart.defaults.color = '#4b5563';

            const legendOptions = {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle',
                    boxWidth: 8,
                    font: { size: 12 },
                    color: '#4b5563',
                },
            };
            const axisTicks = { color: '#4b5563', font: { size: 12 } };
            const gridOptions = { color: '#f1f5f9', drawBorder: false };
            const borderOptions = { display: false };
            const distinctBgColors = [
                '#6ee7b7',
                '#34d399',
                '#a7f3d0',
                '#93c5fd',
                '#94a3b8',
                '#cbd5e1',
                '#e2e8f0',
            ];

            // --- Dosen Jurusan Chart (Pie) ---
            const dosenJurusanDataRaw = @json($dosenPerJurusan);
            new Chart(document.getElementById('dosenJurusanChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: dosenJurusanDataRaw.map(i => i.jurusan || 'Unknown'),
                    datasets: [{ data: dosenJurusanDataRaw.map(i => i.total), backgroundColor: distinctBgColors, borderWidth: 0 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: legendOptions,
                        datalabels: {
                            color: '#1f2937', font: { size: 12, weight: 'bold' },
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
                        backgroundColor: '#93c5fd',
                        borderRadius: 6,
                        barThickness: 26
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true, maintainAspectRatio: false,
                    scales: {
                        x: { beginAtZero: true, ticks: { stepSize: 1, ...axisTicks }, grid: gridOptions, border: borderOptions },
                        y: { grid: gridOptions, border: borderOptions, ticks: axisTicks }
                    },
                    plugins: {
                        legend: { display: false },
                        datalabels: { color: '#4b5563', anchor: 'end', align: 'right', font: { size: 12, weight: 'bold' } }
                    }
                }
            });

            // --- Kinerja per Kategori (Doughnut) ---
            const kinerjaDataRaw = @json($kinerjaPerKategori);
            const kinerjaColors = {
                'Sangat Baik': '#34d399',
                'Baik':        '#6ee7b7',
                'Cukup':       '#93c5fd',
                'Kurang':      '#cbd5e1',
            };
            new Chart(document.getElementById('kinerjaKategoriChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: kinerjaDataRaw.map(i => i.kategori),
                    datasets: [{
                        data: kinerjaDataRaw.map(i => i.total),
                        backgroundColor: kinerjaDataRaw.map(i => kinerjaColors[i.kategori] || '#e2e8f0'),
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: legendOptions,
                        datalabels: {
                            color: '#1f2937', font: { size: 12, weight: 'bold' },
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
            const statusColors = dosenStatusDataRaw.map(i => i.status === 'Aktif' ? '#6ee7b7' : '#cbd5e1');
            new Chart(document.getElementById('dosenStatusChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: dosenStatusDataRaw.map(i => i.status),
                    datasets: [{
                        label: 'Jumlah Dosen',
                        data: dosenStatusDataRaw.map(i => i.total),
                        backgroundColor: statusColors, borderRadius: 6, barThickness: 26
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1, ...axisTicks }, grid: gridOptions, border: borderOptions },
                        x: { grid: gridOptions, border: borderOptions, ticks: axisTicks }
                    },
                    plugins: {
                        legend: { display: false },
                        datalabels: { color: '#4b5563', anchor: 'end', align: 'top', font: { size: 12, weight: 'bold' }, formatter: v => v }
                    }
                }
            });
        });
    </script>
    @endpush
</x-adminlte-layout>
