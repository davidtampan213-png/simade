<x-adminlte-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">📊 Kinerja — {{ $dosen->nama }}</h1>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body bg-body-tertiary border-bottom">
            <div class="row g-2 align-items-end">
                <div class="col-12 col-sm-6 col-lg-4">
                    <p class="text-body-secondary mb-1 small">Riwayat kinerja dosen</p>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 d-flex gap-2">
                    <a href="{{ route('dosen.show', $dosen->id) }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
                    <a href="{{ route('dosen.kinerja.create', $dosen->id) }}" class="btn btn-success btn-sm">+ Tambah Kinerja</a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-nowrap">No</th>
                        <th class="text-nowrap">Periode</th>
                        <th class="text-nowrap">Kategori</th>
                        <th class="text-nowrap">Catatan</th>
                        <th class="text-center text-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kinerjaDosens as $i => $k)
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
                        <td class="text-nowrap">{{ $kinerjaDosens->firstItem() + $i }}</td>
                        <td class="text-nowrap">{{ $k->periode }}</td>
                        <td class="text-nowrap">
                            <span class="badge {{ $badgeClass }}">
                                {{ $k->kategori }}
                            </span>
                        </td>
                        <td class="text-nowrap">{{ $k->catatan ?? '-' }}</td>
                        <td class="text-center text-nowrap">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('dosen.kinerja.edit', [$dosen->id, $k->id]) }}" class="btn btn-outline-info btn-sm">Edit</a>
                                <form action="{{ route('dosen.kinerja.destroy', [$dosen->id, $k->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data kinerja ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-body-secondary">Belum ada data kinerja.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer py-3">
            {{ $kinerjaDosens->links() }}
        </div>
    </div>
</x-adminlte-layout>
