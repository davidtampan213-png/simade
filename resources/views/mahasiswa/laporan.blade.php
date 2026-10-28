<x-adminlte-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3">
            <div class="d-flex items-center gap-3">
                <a href="{{ route('dashboard.mahasiswa') }}" class="text-success text-decoration-none">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h1 class="h3 mb-0 fw-semibold">Laporan Mahasiswa per Fakultas</h1>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('mahasiswa.laporan.export', array_merge(request()->query(), ['format'=>'excel'])) }}"
                   class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                    <i class="bi bi-file-earmark-excel"></i> Ekspor Excel
                </a>
                <a href="{{ route('mahasiswa.laporan.export', array_merge(request()->query(), ['format'=>'pdf'])) }}"
                   class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1">
                    <i class="bi bi-file-earmark-pdf"></i> Ekspor PDF
                </a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-start gap-2" role="alert">
            <i class="bi bi-check-circle-fill mt-1"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="row g-3">
        {{-- Filter --}}
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('mahasiswa.laporan') }}" class="row g-3 align-items-end">
                        <div class="col-12 col-sm-5">
                            <label for="tahun_akademik" class="form-label small fw-semibold text-uppercase">Tahun Akademik</label>
                            <select id="tahun_akademik" name="tahun_akademik" class="form-select form-select-sm">
                                <option value="">Semua Tahun</option>
                                @foreach($tahunList as $ta)
                                    <option value="{{ $ta }}" {{ $tahunAkademik == $ta ? 'selected' : '' }}>{{ $ta }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-5">
                            <label for="semester" class="form-label small fw-semibold text-uppercase">Semester</label>
                            <select id="semester" name="semester" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                @for($s=1; $s<=14; $s++)
                                    <option value="{{ $s }}" {{ $semester == $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-12 col-sm-2 d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-sm w-100 d-flex align-items-center justify-content-center gap-1">
                                <i class="bi bi-funnel"></i> Terapkan
                            </button>
                        </div>
                    </form>

                    @if($tahunAkademik || $semester)
                        <div class="alert alert-light border mt-3 mb-0 d-flex flex-wrap align-items-center justify-content-between gap-2 small">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <i class="bi bi-funnel-fill text-success"></i>
                                <span>Filter aktif:</span>
                                @if($tahunAkademik)
                                    <span class="badge text-bg-success">T.A. {{ $tahunAkademik }}</span>
                                @endif
                                @if($semester)
                                    <span class="badge text-bg-success">Semester {{ $semester }}</span>
                                @endif
                            </div>
                            <a href="{{ route('mahasiswa.laporan') }}" class="link-success small">Hapus filter</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kartu Ringkasan Global --}}
        <div class="col-12">
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="small-box text-bg-success h-100">
                        <div class="inner">
                            <p>Total Mahasiswa</p>
                            <h3>{{ number_format($totalAll) }}</h3>
                        </div>
                        <div class="icon"><i class="bi bi-people"></i></div>
                        <a href="{{ route('mahasiswa.index', array_filter(['tahun_akademik' => $tahunAkademik, 'semester' => $semester])) }}"
                           class="small-box-footer">Lihat detail <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="small-box text-bg-primary h-100">
                        <div class="inner">
                            <p>Mahasiswa Aktif</p>
                            <h3>{{ number_format($totalAktif) }}</h3>
                        </div>
                        <div class="icon"><i class="bi bi-person-check"></i></div>
                        <a href="{{ route('mahasiswa.index', array_filter(['status' => 'Aktif', 'tahun_akademik' => $tahunAkademik, 'semester' => $semester])) }}"
                           class="small-box-footer">Lihat detail <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="small-box text-bg-danger h-100">
                        <div class="inner">
                            <p>Mahasiswa Nonaktif</p>
                            <h3>{{ number_format($totalNonaktif) }}</h3>
                        </div>
                        <div class="icon"><i class="bi bi-person-x"></i></div>
                        <a href="{{ route('mahasiswa.index', array_filter(['status' => 'Nonaktif', 'tahun_akademik' => $tahunAkademik, 'semester' => $semester])) }}"
                           class="small-box-footer">Lihat detail <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="small-box text-bg-warning h-100">
                        <div class="inner">
                            <p>Mahasiswa Cuti</p>
                            <h3>{{ number_format($totalCuti) }}</h3>
                        </div>
                        <div class="icon"><i class="bi bi-calendar-minus"></i></div>
                        <a href="{{ route('mahasiswa.index', array_filter(['status' => 'Cuti', 'tahun_akademik' => $tahunAkademik, 'semester' => $semester])) }}"
                           class="small-box-footer">Lihat detail <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Batang Perbandingan per Fakultas --}}
        @if($statsPerFakultas->count() > 0)
        <div class="col-12">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h3 class="card-title mb-0">Perbandingan Status per Fakultas</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative" style="height: {{ max(200, $statsPerFakultas->count() * 50) }}px">
                        <canvas id="fakultasChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Tabel Statistik per Fakultas --}}
        <div class="col-12">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0">
                    <h3 class="card-title mb-0">Statistik per Fakultas</h3>
                    <p class="card-subtitle text-body-secondary small mb-0">Klik nama fakultas untuk melihat detail per program studi</p>
                </div>

                @if($statsPerFakultas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Fakultas</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Aktif</th>
                                    <th class="text-center">Nonaktif</th>
                                    <th class="text-center">Cuti</th>
                                    <th class="text-center">% Aktif</th>
                                    <th class="text-center">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statsPerFakultas as $f)
                                    @php
                                        $fTotal = $f->total ?: 0;
                                        $fAktif = $f->aktif ?: 0;
                                        $fNonaktif = $f->nonaktif ?: 0;
                                        $fCuti = $f->cuti ?: 0;
                                        $persenAktif = $fTotal > 0 ? round(($fAktif / $fTotal) * 100) : 0;
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold">{{ $f->fakultas }}</td>
                                        <td class="text-center fw-semibold">{{ number_format($fTotal) }}</td>
                                        <td class="text-center"><span class="badge text-bg-success">{{ $fAktif }}</span></td>
                                        <td class="text-center"><span class="badge text-bg-danger">{{ $fNonaktif }}</span></td>
                                        <td class="text-center"><span class="badge text-bg-warning">{{ $fCuti }}</span></td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" role="progressbar" aria-label="Tingkat keaktifan" aria-valuenow="{{ $persenAktif }}" aria-valuemin="0" aria-valuemax="100" style="height: 6px;">
                                                    <div class="progress-bar bg-success" style="width: {{ $persenAktif }}%"></div>
                                                </div>
                                                <span class="small text-nowrap">{{ $persenAktif }}%</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('mahasiswa.laporan.fakultas', urlencode($f->fakultas)) }}?tahun_akademik={{ $tahunAkademik }}&semester={{ $semester }}"
                                               class="btn btn-outline-success btn-sm d-flex align-items-center gap-1">
                                                <i class="bi bi-arrow-right"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="card-body text-center text-body-secondary py-5">
                        <i class="bi bi-bar-chart-line fs-1 d-block mb-2"></i>
                        Tidak ada data fakultas pada periode yang dipilih.
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fakultasCanvas = document.getElementById('fakultasChart');
            if (!fakultasCanvas) return;

            const fakultasData = @json($statsPerFakultas);
            const labels = fakultasData.map(item => item.fakultas);
            const aktif = fakultasData.map(item => item.aktif || 0);
            const nonaktif = fakultasData.map(item => item.nonaktif || 0);
            const cuti = fakultasData.map(item => item.cuti || 0);

            new Chart(fakultasCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Aktif',
                            data: aktif,
                            backgroundColor: 'rgba(16, 185, 129, 0.85)',
                            borderColor: '#059669',
                            borderWidth: 1,
                            borderRadius: 4
                        },
                        {
                            label: 'Nonaktif',
                            data: nonaktif,
                            backgroundColor: 'rgba(239, 68, 68, 0.85)',
                            borderColor: '#dc2626',
                            borderWidth: 1,
                            borderRadius: 4
                        },
                        {
                            label: 'Cuti',
                            data: cuti,
                            backgroundColor: 'rgba(245, 158, 11, 0.85)',
                            borderColor: '#d97706',
                            borderWidth: 1,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ` ${context.dataset.label}: ${context.raw} mahasiswa`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            stacked: true,
                            ticks: { stepSize: 1 }
                        },
                        y: { stacked: true }
                    }
                }
            });
        });
    </script>
    @endpush
</x-adminlte-layout>