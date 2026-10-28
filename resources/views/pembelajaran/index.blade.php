<x-adminlte-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">📚 Pembelajaran — {{ $dosen->nama }}</h1>
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
                    <p class="text-body-secondary mb-1 small">Total SKS: <strong>{{ $pembelajarans->sum('sks') }}</strong></p>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 d-flex gap-2">
                    <a href="{{ route('dosen.show', $dosen->id) }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
                    <a href="{{ route('dosen.pembelajaran.create', $dosen->id) }}" class="btn btn-success btn-sm">+ Tambah MK</a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-nowrap">No</th>
                        <th class="text-nowrap">Mata Kuliah</th>
                        <th class="text-nowrap">SKS</th>
                        <th class="text-nowrap">Semester</th>
                        <th class="text-nowrap">Tahun Ajaran</th>
                        <th class="text-nowrap">Kelas</th>
                        <th class="text-center text-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembelajarans as $i => $pb)
                    <tr>
                        <td class="text-nowrap">{{ $pembelajarans->firstItem() + $i }}</td>
                        <td class="text-nowrap">{{ $pb->nama_mk }}</td>
                        <td class="text-nowrap">{{ $pb->sks }}</td>
                        <td class="text-nowrap">{{ $pb->semester }}</td>
                        <td class="text-nowrap">{{ $pb->tahun_ajaran }}</td>
                        <td class="text-nowrap">{{ $pb->kelas }}</td>
                        <td class="text-center text-nowrap">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('dosen.pembelajaran.edit', [$dosen->id, $pb->id]) }}" class="btn btn-outline-info btn-sm">Edit</a>
                                <form action="{{ route('dosen.pembelajaran.destroy', [$dosen->id, $pb->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pembelajaran ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-body-secondary">Belum ada data pembelajaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer py-3">
            {{ $pembelajarans->links() }}
        </div>
    </div>
</x-adminlte-layout>
