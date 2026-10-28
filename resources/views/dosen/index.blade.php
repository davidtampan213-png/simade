<x-adminlte-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-sm-between gap-3">
            <h1 class="h3 mb-0">Data Dosen</h1>
            <a href="{{ route('dosen.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-person-plus me-1"></i> Tambah Dosen
            </a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body bg-body-tertiary border-bottom">
            <form method="GET" action="{{ route('dosen.index') }}" class="row g-2 align-items-end">
                <div class="col-12 col-sm-6 col-lg-4">
                    <label for="search" class="form-label small fw-semibold text-body-secondary text-uppercase mb-1">Cari NIP / Nama</label>
                    <input id="search" type="text" name="search" placeholder="Cari NIP/Nama" value="{{ request('search') }}" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-sm-6 col-lg-3 d-flex gap-2">
                    <button type="submit" class="btn btn-success btn-sm">Filter</button>
                    <a href="{{ route('dosen.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-nowrap">NIP</th>
                        <th class="text-nowrap">Nama</th>
                        <th class="text-nowrap">Jabatan</th>
                        <th class="text-nowrap">Prodi</th>
                        <th class="text-nowrap">Jurusan</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-center text-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dosens as $dsn)
                    <tr>
                        <td class="text-nowrap fw-medium">{{ $dsn->nip }}</td>
                        <td class="text-nowrap">{{ $dsn->nama }}</td>
                        <td class="text-nowrap">{{ $dsn->jabatan ?? '-' }}</td>
                        <td class="text-nowrap">{{ $dsn->prodi ?? '-' }}</td>
                        <td class="text-nowrap">{{ $dsn->jurusan }}</td>
                        <td class="text-nowrap">
                            <span class="badge {{ $dsn->status === 'Aktif' ? 'text-bg-success' : 'text-bg-danger' }}">{{ $dsn->status }}</span>
                        </td>
                        <td class="text-center text-nowrap">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('dosen.show', $dsn->id) }}" class="btn btn-outline-info btn-sm">Detail</a>
                                <a href="{{ route('dosen.edit', $dsn->id) }}" class="btn btn-outline-success btn-sm">Edit</a>
                                <form action="{{ route('dosen.destroy', $dsn->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-body-secondary">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer py-3">
            {{ $dosens->links() }}
        </div>
    </div>
</x-adminlte-layout>
