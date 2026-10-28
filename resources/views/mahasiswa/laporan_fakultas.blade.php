<x-adminlte-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('mahasiswa.laporan') }}" class="btn btn-outline-secondary btn-sm" title="Kembali ke laporan">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h1 class="h3 mb-0 fw-semibold">{{ $fakultas }}</h1>
                    <p class="text-body-secondary small mb-0">Laporan Detail Fakultas</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('mahasiswa.laporan.export', array_merge(request()->query(), ['format'=>'excel','fakultas'=>$fakultas])) }}"
                   class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
                <a href="{{ route('mahasiswa.laporan.export', array_merge(request()->query(), ['format'=>'pdf','fakultas'=>$fakultas])) }}"
                   class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
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
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-12 col-md-3">
                            <label class="form-label small fw-semibold text-uppercase">Tahun Akademik</label>
                            <select name="tahun_akademik" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                @foreach($tahunList as $ta)
                                    <option value="{{ $ta }}" {{ $tahunAkademik == $ta ? 'selected' : '' }}>{{ $ta }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label small fw-semibold text-uppercase">Semester</label>
                            <select name="semester" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                @for($s=1; $s<=14; $s++)
                                    <option value="{{ $s }}" {{ $semester == $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold text-uppercase">Filter Prodi</label>
                            <select name="program_studi" class="form-select form-select-sm">
                                <option value="">Semua Prodi</option>
                                @foreach($daftarProdi as $p)
                                    <option value="{{ $p }}" {{ $prodiFilter == $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-sm w-100 d-flex align-items-center justify-content-center gap-1">
                                <i class="bi bi-funnel"></i> Terapkan
                            </button>
                            <a href="{{ route('mahasiswa.laporan.fakultas', $fakultas) }}"
                               class="btn btn-outline-secondary btn-sm" title="Reset filter">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kartu Statistik Fakultas --}}
        <div class="col-12">
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="small-box text-bg-success h-100">
                        <div class="inner">
                            <p>Total Mahasiswa</p>
                            <h3>{{ number_format($totalAll) }}</h3>
                        </div>
                        <div class="icon"><i class="bi bi-people"></i></div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="small-box text-bg-primary h-100">
                        <div class="inner">
                            <p>Mahasiswa Aktif</p>
                            <h3>{{ number_format($totalAktif) }}</h3>
                        </div>
                        <div class="icon"><i class="bi bi-person-check"></i></div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="small-box text-bg-danger h-100">
                        <div class="inner">
                            <p>Mahasiswa Nonaktif</p>
                            <h3>{{ number_format($totalNonaktif) }}</h3>
                        </div>
                        <div class="icon"><i class="bi bi-person-x"></i></div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="small-box text-bg-warning h-100">
                        <div class="inner">
                            <p>Mahasiswa Cuti</p>
                            <h3>{{ number_format($totalCuti) }}</h3>
                        </div>
                        <div class="icon"><i class="bi bi-calendar-minus"></i></div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik per Program Studi --}}
        @if($statsPerProdi->count() > 0)
        <div class="col-12">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 d-flex align-items-center justify-content-between">
                    <h3 class="card-title mb-0">Statistik per Program Studi</h3>
                    <span class="text-body-secondary small">{{ $statsPerProdi->count() }} program studi</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Program Studi</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Aktif</th>
                                <th class="text-center">Nonaktif</th>
                                <th class="text-center">Cuti</th>
                                <th>Distribusi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statsPerProdi as $p)
                                @php
                                    $pTotal = $p->total ?: 1;
                                    $wA = round($p->aktif / $pTotal * 100);
                                    $wN = round($p->nonaktif / $pTotal * 100);
                                    $wC = round($p->cuti / $pTotal * 100);
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('mahasiswa.laporan.fakultas', urlencode($fakultas)) }}?program_studi={{ urlencode($p->program_studi) }}&tahun_akademik={{ $tahunAkademik }}&semester={{ $semester }}"
                                           class="fw-semibold text-success text-decoration-none">
                                            {{ $p->program_studi }}
                                        </a>
                                    </td>
                                    <td class="text-center fw-bold">{{ $p->total }}</td>
                                    <td class="text-center"><span class="badge text-bg-success">{{ $p->aktif }}</span></td>
                                    <td class="text-center"><span class="badge text-bg-danger">{{ $p->nonaktif }}</span></td>
                                    <td class="text-center"><span class="badge text-bg-warning">{{ $p->cuti }}</span></td>
                                    <td>
                                        <div class="progress" style="height: 8px; min-width: 120px;" role="progressbar">
                                            @if($wA > 0)<div class="progress-bar bg-success" style="width:{{ $wA }}%" title="Aktif: {{ $wA }}%"></div>@endif
                                            @if($wN > 0)<div class="progress-bar bg-danger" style="width:{{ $wN }}%" title="Nonaktif: {{ $wN }}%"></div>@endif
                                            @if($wC > 0)<div class="progress-bar bg-warning" style="width:{{ $wC }}%" title="Cuti: {{ $wC }}%"></div>@endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        {{-- Daftar Mahasiswa --}}
        <div class="col-12">
            <div class="card shadow-sm h-100">
                <div class="card-header border-0 d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="card-title mb-0">Daftar Mahasiswa{{ $prodiFilter ? ' — ' . $prodiFilter : '' }}</h3>
                        <p class="card-subtitle text-body-secondary small mb-0">Rincian data mahasiswa terdaftar</p>
                    </div>
                    <span class="badge text-bg-light border">{{ $mahasiswas->total() }} mahasiswa</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Program Studi</th>
                                <th>Jenjang</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mahasiswas as $mhs)
                                <tr>
                                    <td class="font-monospace">{{ $mhs->nim }}</td>
                                    <td class="fw-medium">{{ $mhs->nama }}</td>
                                    <td>{{ $mhs->program_studi ?? '-' }}</td>
                                    <td><span class="badge text-bg-light border">{{ $mhs->jenjang }}</span></td>
                                    <td class="text-center">{{ $mhs->semester ?? '-' }}</td>
                                    <td class="text-center">
                                        @if($mhs->status == 'Aktif')
                                            <span class="badge text-bg-success">Aktif</span>
                                        @elseif($mhs->status == 'Cuti')
                                            <span class="badge text-bg-warning">Cuti</span>
                                        @else
                                            <span class="badge text-bg-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('mahasiswa.show', $mhs->id) }}" class="btn btn-outline-success btn-sm">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-5 text-center text-body-secondary">
                                        Tidak ada data mahasiswa yang sesuai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($mahasiswas->hasPages())
                    <div class="card-footer bg-white border-top">
                        {{ $mahasiswas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-adminlte-layout>