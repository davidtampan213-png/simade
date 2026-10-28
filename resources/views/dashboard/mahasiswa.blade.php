<x-adminlte-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3">
            <div>
                <h1 class="h3 mb-0 fw-semibold">Dashboard Statistik Mahasiswa</h1>
                <p class="text-body-secondary mb-0">Ringkasan data akademik, status keaktifan, dan sebaran fakultas SIMADE</p>
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

    {{-- Small Boxes (4 stats) --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box text-bg-success h-100">
                <div class="inner">
                    <p>Total Mahasiswa</p>
                    <h3 class="fw-bold">{{ number_format($totalMahasiswa) }}</h3>
                </div>
                <div class="icon"><i class="bi bi-people"></i></div>
                <a href="{{ route('mahasiswa.index', ['status'=>'Aktif']) }}" class="small-box-footer">Lihat detail <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box text-bg-primary h-100">
                <div class="inner">
                    <p>Mahasiswa Aktif</p>
                    <h3 class="fw-bold">{{ number_format($totalMahasiswaAktif) }}</h3>
                </div>
                <div class="icon"><i class="bi bi-person-check"></i></div>
                <div class="small-box-footer">&nbsp;</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box text-bg-danger h-100">
                <div class="inner">
                    <p>Mahasiswa Nonaktif</p>
                    <h3 class="fw-bold">{{ number_format($totalMahasiswaNonaktif) }}</h3>
                </div>
                <div class="icon"><i class="bi bi-person-x"></i></div>
                <div class="small-box-footer">&nbsp;</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box text-bg-warning h-100">
                <div class="inner">
                    <p>Mahasiswa Cuti</p>
                    <h3 class="fw-bold">{{ number_format($totalMahasiswaCuti) }}</h3>
                </div>
                <div class="icon"><i class="bi bi-calendar-minus"></i></div>
                <div class="small-box-footer">&nbsp;</div>
            </div>
        </div>
    </div>

    {{-- Stats by Jurusan and Fakultas --}}
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
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
            <div class="card shadow-sm h-100">
                <div class="card-header">
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
</x-adminlte-layout>
