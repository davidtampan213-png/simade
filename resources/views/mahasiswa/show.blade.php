<x-adminlte-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary btn-sm" title="Kembali">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h1 class="h3 mb-0">Detail Mahasiswa</h1>
            </div>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}"
               class="btn btn-success btn-sm">
                <i class="bi bi-pencil me-1"></i> Edit Data
            </a>
            @endif
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">

            {{-- Kartu Identitas --}}
            <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                {{-- Header kartu --}}
                <div class="card-header bg-success text-white p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white bg-opacity-25 text-white d-flex align-items-center justify-content-center fw-bold fs-3"
                             style="width: 64px; height: 64px; min-width: 64px;">
                            {{ mb_strtoupper(mb_substr($mahasiswa->nama, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="card-title text-white mb-1 fw-bold">{{ $mahasiswa->nama }}</h4>
                            <p class="mb-2 text-white-50 font-monospace small">NIM: {{ $mahasiswa->nim }}</p>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                @if($mahasiswa->status == 'Aktif')
                                    <span class="badge text-bg-success"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                                @elseif($mahasiswa->status == 'Cuti')
                                    <span class="badge text-bg-warning"><i class="bi bi-pause-circle me-1"></i>Cuti</span>
                                @else
                                    <span class="badge text-bg-danger"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>
                                @endif
                                @if($mahasiswa->status_beasiswa)
                                    <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-50">
                                        <i class="bi bi-mortarboard me-1"></i>Penerima Beasiswa
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Informasi detail --}}
                <div class="card-body p-4">
                    @php
                        $fields = [
                            ['label' => 'Jenis Kelamin',    'value' => $mahasiswa->jenis_kelamin_label],
                            ['label' => 'Fakultas',          'value' => $mahasiswa->fakultas ?? '-'],
                            ['label' => 'Program Studi',     'value' => $mahasiswa->program_studi ?? '-'],
                            ['label' => 'Jenjang',           'value' => $mahasiswa->jenjang ?? '-'],
                            ['label' => 'Semester',          'value' => $mahasiswa->semester ? 'Semester ' . $mahasiswa->semester : '-'],
                            ['label' => 'Tahun Akademik',    'value' => $mahasiswa->tahun_akademik ?? '-'],
                            ['label' => 'Jenis Kelas',       'value' => $mahasiswa->jenis_kelas],
                            ['label' => 'No HP',             'value' => $mahasiswa->no_hp ?? '-'],
                        ];
                    @endphp

                    <div class="row g-4 mb-3">
                        @foreach($fields as $f)
                        <div class="col-12 col-sm-6">
                            <div class="pb-2 border-bottom">
                                <span class="d-block small text-body-secondary text-uppercase fw-semibold mb-1">{{ $f['label'] }}</span>
                                <span class="fw-medium text-body">{{ $f['value'] }}</span>
                            </div>
                        </div>
                        @endforeach

                        <div class="col-12">
                            <div class="pb-2 border-bottom">
                                <span class="d-block small text-body-secondary text-uppercase fw-semibold mb-1">Alamat</span>
                                <span class="text-body">{{ $mahasiswa->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="small text-body-secondary mt-3">
                        Ditambahkan: {{ $mahasiswa->created_at ? $mahasiswa->created_at->format('d M Y H:i') : '-' }} &bull;
                        Diperbarui: {{ $mahasiswa->updated_at ? $mahasiswa->updated_at->format('d M Y H:i') : '-' }}
                    </div>
                </div>
            </div>

            {{-- Riwayat Status --}}
            @if($riwayat->count() > 0)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-body-tertiary py-3 border-bottom">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="bi bi-clock-history me-2"></i>Riwayat Status per Semester
                    </h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($riwayat as $r)
                        <li class="list-group-item d-flex align-items-center justify-content-between py-3 px-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center fw-bold fs-6"
                                     style="width: 38px; height: 38px; min-width: 38px;">
                                    {{ $r->semester }}
                                </div>
                                <div>
                                    <div class="fw-semibold text-body">Semester {{ $r->semester }}</div>
                                    <small class="text-body-secondary">Tahun Akademik {{ $r->tahun_akademik }}</small>
                                </div>
                            </div>
                            <div>
                                @if($r->status == 'Aktif')
                                    <span class="badge text-bg-success">Aktif</span>
                                @elseif($r->status == 'Cuti')
                                    <span class="badge text-bg-warning">Cuti</span>
                                @else
                                    <span class="badge text-bg-danger">Nonaktif</span>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            {{-- Tombol aksi --}}
            @if(Auth::user()->isAdmin())
            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}"
                   class="btn btn-success btn-sm px-3">
                    <i class="bi bi-pencil me-1"></i> Edit Data
                </a>
                <form action="{{ route('mahasiswa.destroy', $mahasiswa->id) }}" method="POST"
                      onsubmit="return confirm('Hapus data {{ addslashes($mahasiswa->nama) }}? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                        <i class="bi bi-trash me-1"></i> Hapus Data
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</x-adminlte-layout>
