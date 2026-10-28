<x-adminlte-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3">
            <div>
                <h1 class="h3 mb-0 fw-semibold">Data Mahasiswa</h1>
                <p class="text-body-secondary small mb-0">Kelola dan pantau data mahasiswa SIMADE</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('mahasiswa.create') }}" class="btn btn-success btn-sm d-inline-flex align-items-center gap-1">
                        <i class="bi bi-plus-lg"></i> Tambah Mahasiswa
                    </a>
                @endif
                <a href="{{ route('mahasiswa.export', array_merge(request()->query(), ['format'=>'excel'])) }}" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
                <a href="{{ route('mahasiswa.export', array_merge(request()->query(), ['format'=>'pdf'])) }}" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
                <a href="{{ route('mahasiswa.laporan') }}" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
                    <i class="bi bi-bar-chart-line"></i> Laporan
                </a>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-start gap-2" role="alert">
            <i class="bi bi-check-circle-fill mt-1"></i>
            <div><strong>Berhasil!</strong> {{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        {{-- Filter Bar --}}
        <div class="card-body bg-body-tertiary border-bottom">
            <form method="GET" action="{{ route('mahasiswa.index') }}" class="row g-3 align-items-end">
                <div class="col-12 col-md-4 col-xl-3">
                    <label class="form-label small fw-semibold text-uppercase" for="search">Cari NIM / Nama</label>
                    <input id="search" type="text" name="search" placeholder="Cari..." value="{{ request('search') }}" class="form-control form-control-sm"/>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-xl-2">
                    <label class="form-label small fw-semibold text-uppercase" for="fakultas">Fakultas</label>
                    <select id="fakultas" name="fakultas" class="form-select form-select-sm" onchange="updateProdi(this.value)">
                        <option value="">Semua Fakultas</option>
                        @foreach(array_keys($daftarFakultas) as $fak)
                            <option value="{{ $fak }}" {{ request('fakultas') == $fak ? 'selected' : '' }}>{{ $fak }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-xl-2">
                    <label class="form-label small fw-semibold text-uppercase" for="prodiSelect">Program Studi</label>
                    <select name="program_studi" id="prodiSelect" class="form-select form-select-sm">
                        <option value="">Semua Prodi</option>
                        @foreach($daftarProdi as $prodi)
                            <option value="{{ $prodi }}" {{ request('program_studi') == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-xl-1">
                    <label class="form-label small fw-semibold text-uppercase" for="jenjang">Jenjang</label>
                    <select id="jenjang" name="jenjang" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach(['D3','S1','S2','S3'] as $j)
                            <option value="{{ $j }}" {{ request('jenjang') == $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-xl-1">
                    <label class="form-label small fw-semibold text-uppercase" for="semester">Semester</label>
                    <select id="semester" name="semester" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @for($s=1; $s<=14; $s++)
                            <option value="{{ $s }}" {{ request('semester') == $s ? 'selected' : '' }}>Sem {{ $s }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-xl-1">
                    <label class="form-label small fw-semibold text-uppercase" for="status">Status</label>
                    <select id="status" name="status" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="Cuti" {{ request('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                    </select>
                </div>

                <div class="col-12 col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-funnel me-1"></i>Filter</button>
                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                </div>
            </form>
        </div>

        {{-- Info hasil filter --}}
        <div class="card-header bg-white d-flex flex-wrap align-items-center justify-content-between gap-2">
            <span class="small text-body-secondary">Menampilkan <strong class="text-body">{{ $mahasiswas->total() }}</strong> mahasiswa</span>
            @if(request()->hasAny(['search','status','fakultas','program_studi','jenjang','semester','jenis_kelamin']))
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-link link-danger btn-sm p-0">Hapus semua filter</a>
            @endif
        </div>

        {{-- Tabel --}}
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle mb-0">
                <thead class="table-success">
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>Fakultas</th>
                        <th>Program Studi</th>
                        <th>Jenjang</th>
                        <th class="text-center">Sem</th>
                        <th>Tahun Akademik</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswas as $mhs)
                    <tr>
                        <td class="font-monospace text-nowrap">{{ $mhs->nim }}</td>
                        <td class="fw-medium text-nowrap">{{ $mhs->nama }}</td>
                        <td class="text-nowrap">{{ $mhs->jenis_kelamin ?? '-' }}</td>
                        <td title="{{ $mhs->fakultas }}">{{ $mhs->fakultas ?? '-' }}</td>
                        <td title="{{ $mhs->program_studi }}">{{ $mhs->program_studi ?? '-' }}</td>
                        <td><span class="badge text-bg-light border text-dark">{{ $mhs->jenjang }}</span></td>
                        <td class="text-center">{{ $mhs->semester ?? '-' }}</td>
                        <td class="text-nowrap">{{ $mhs->tahun_akademik ?? '-' }}</td>
                        <td>
                            @if($mhs->status == 'Aktif')
                                <span class="badge text-bg-success">Aktif</span>
                            @elseif($mhs->status == 'Cuti')
                                <span class="badge text-bg-warning">Cuti</span>
                            @else
                                <span class="badge text-bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Aksi mahasiswa">
                                <a href="{{ route('mahasiswa.show', $mhs->id) }}" class="btn btn-outline-info" title="Detail" aria-label="Detail {{ $mhs->nama }}"><i class="bi bi-eye"></i></a>
                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('mahasiswa.edit', $mhs->id) }}" class="btn btn-outline-success" title="Edit" aria-label="Edit {{ $mhs->nama }}"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data {{ addslashes($mhs->nama) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus" aria-label="Hapus {{ $mhs->nama }}"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="py-5 text-center text-body-secondary">
                            <i class="bi bi-search fs-2 d-block mb-2"></i>
                            Data tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($mahasiswas->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $mahasiswas->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
    // Filter prodi berdasarkan fakultas
    const daftarFakultas = @json($daftarFakultas);
    const allProdi = @json($daftarProdi);
    const currentProdi = "{{ request('program_studi') }}";

    function updateProdi(fakultas) {
        const sel = document.getElementById('prodiSelect');
        sel.innerHTML = '<option value="">Semua Prodi</option>';
        const list = fakultas ? (daftarFakultas[fakultas] ?? []) : allProdi;
        list.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p;
            opt.textContent = p;
            if (p === currentProdi) opt.selected = true;
            sel.appendChild(opt);
        });
    }

    // Init on load
    updateProdi("{{ request('fakultas') }}");
    </script>
    @endpush
</x-adminlte-layout>
