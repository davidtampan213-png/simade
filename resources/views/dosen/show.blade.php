<x-adminlte-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Detail Data Dosen</h1>
    </x-slot>

    <div class="d-flex flex-column gap-4">
        {{-- ===================== IDENTITAS ===================== --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">Identitas Dosen</h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('dosen.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
                    <a href="{{ route('dosen.edit', $dosen->id) }}" class="btn btn-success btn-sm">Edit Data</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <small class="text-body-secondary fw-semibold text-uppercase d-block">NIP</small>
                        <span class="fw-medium text-body">{{ $dosen->nip }}</span>
                    </div>
                    <div class="col-12 col-md-4">
                        <small class="text-body-secondary fw-semibold text-uppercase d-block">Nama Lengkap</small>
                        <span class="fw-medium text-body">{{ $dosen->nama }}</span>
                    </div>
                    <div class="col-12 col-md-4">
                        <small class="text-body-secondary fw-semibold text-uppercase d-block">Jabatan</small>
                        <span class="fw-medium text-body">{{ $dosen->jabatan ?? '-' }}</span>
                    </div>
                    <div class="col-12 col-md-4">
                        <small class="text-body-secondary fw-semibold text-uppercase d-block">Program Studi</small>
                        <span class="fw-medium text-body">{{ $dosen->prodi ?? '-' }}</span>
                    </div>
                    <div class="col-12 col-md-4">
                        <small class="text-body-secondary fw-semibold text-uppercase d-block">Jurusan</small>
                        <span class="fw-medium text-body">{{ $dosen->jurusan }}</span>
                    </div>
                    <div class="col-12 col-md-4">
                        <small class="text-body-secondary fw-semibold text-uppercase d-block">Status</small>
                        <span class="badge {{ $dosen->status === 'Aktif' ? 'text-bg-success' : 'text-bg-danger' }}">
                            {{ $dosen->status }}
                        </span>
                    </div>
                    <div class="col-12 col-md-4">
                        <small class="text-body-secondary fw-semibold text-uppercase d-block">No HP</small>
                        <span class="fw-medium text-body">{{ $dosen->no_hp ?? '-' }}</span>
                    </div>
                    <div class="col-12 col-md-8">
                        <small class="text-body-secondary fw-semibold text-uppercase d-block">Alamat</small>
                        <span class="fw-medium text-body">{{ $dosen->alamat ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== PENELITIAN ===================== --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">
                    Penelitian
                    <span class="text-body-secondary fs-6 fw-normal">(Total: {{ $dosen->penelitians->count() }})</span>
                </h2>
                <a href="{{ route('dosen.penelitian.create', $dosen->id) }}" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </a>
            </div>
            <div class="card-body p-0">
                @if($dosen->penelitians->isEmpty())
                    <p class="text-body-secondary fst-italic p-3 mb-0">Belum ada data penelitian.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap" style="width: 50px;">No</th>
                                    <th class="text-nowrap">Judul</th>
                                    <th class="text-nowrap">Tahun</th>
                                    <th class="text-nowrap">Sumber Dana</th>
                                    <th class="text-center text-nowrap" style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dosen->penelitians->sortByDesc('tahun') as $i => $p)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $p->judul }}</td>
                                    <td class="text-nowrap">{{ $p->tahun }}</td>
                                    <td class="text-nowrap">{{ $p->sumber_dana ?? '-' }}</td>
                                    <td class="text-center text-nowrap">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('dosen.penelitian.edit', [$dosen->id, $p->id]) }}" class="btn btn-outline-success btn-sm">Edit</a>
                                            <form action="{{ route('dosen.penelitian.destroy', [$dosen->id, $p->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus penelitian ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- ===================== PEMBELAJARAN ===================== --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">
                    Pembelajaran per Semester
                    <span class="text-body-secondary fs-6 fw-normal">(Total SKS: {{ $dosen->pembelajarans->sum('sks') }})</span>
                </h2>
                <a href="{{ route('dosen.pembelajaran.create', $dosen->id) }}" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </a>
            </div>
            <div class="card-body p-0">
                @if($dosen->pembelajarans->isEmpty())
                    <p class="text-body-secondary fst-italic p-3 mb-0">Belum ada data pembelajaran.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap" style="width: 50px;">No</th>
                                    <th class="text-nowrap">Mata Kuliah</th>
                                    <th class="text-nowrap">SKS</th>
                                    <th class="text-nowrap">Semester</th>
                                    <th class="text-nowrap">Tahun Ajaran</th>
                                    <th class="text-nowrap">Kelas</th>
                                    <th class="text-center text-nowrap" style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dosen->pembelajarans->sortByDesc('tahun_ajaran') as $i => $pb)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $pb->nama_mk }}</td>
                                    <td class="text-nowrap">{{ $pb->sks }}</td>
                                    <td class="text-nowrap">{{ $pb->semester }}</td>
                                    <td class="text-nowrap">{{ $pb->tahun_ajaran }}</td>
                                    <td class="text-nowrap">{{ $pb->kelas }}</td>
                                    <td class="text-center text-nowrap">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('dosen.pembelajaran.edit', [$dosen->id, $pb->id]) }}" class="btn btn-outline-success btn-sm">Edit</a>
                                            <form action="{{ route('dosen.pembelajaran.destroy', [$dosen->id, $pb->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pembelajaran ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- ===================== KINERJA ===================== --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">Kinerja Dosen</h2>
                <a href="{{ route('dosen.kinerja.create', $dosen->id) }}" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </a>
            </div>
            <div class="card-body p-0">
                @if($dosen->kinerjaDosens->isEmpty())
                    <p class="text-body-secondary fst-italic p-3 mb-0">Belum ada data kinerja.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap" style="width: 50px;">No</th>
                                    <th class="text-nowrap">Periode</th>
                                    <th class="text-nowrap">Kategori</th>
                                    <th class="text-nowrap">Catatan</th>
                                    <th class="text-center text-nowrap" style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dosen->kinerjaDosens->sortByDesc('created_at') as $i => $k)
                                @php
                                    $badgeClass = match($k->kategori) {
                                        'Sangat Baik' => 'text-bg-success',
                                        'Baik'        => 'text-bg-primary',
                                        'Cukup'       => 'text-bg-warning',
                                        'Kurang'      => 'text-bg-danger',
                                        default       => 'text-bg-secondary',
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="text-nowrap">{{ $k->periode }}</td>
                                    <td class="text-nowrap">
                                        <span class="badge {{ $badgeClass }}">
                                            {{ $k->kategori }}
                                        </span>
                                    </td>
                                    <td>{{ $k->catatan ?? '-' }}</td>
                                    <td class="text-center text-nowrap">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('dosen.kinerja.edit', [$dosen->id, $k->id]) }}" class="btn btn-outline-success btn-sm">Edit</a>
                                            <form action="{{ route('dosen.kinerja.destroy', [$dosen->id, $k->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data kinerja ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-adminlte-layout>
