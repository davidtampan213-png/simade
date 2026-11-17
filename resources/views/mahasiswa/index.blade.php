<x-adminlte-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3">
            <div>
                <h1 class="h3 mb-0 fw-semibold" style="color:#111827;font-weight:700;">Data Mahasiswa</h1>
                <p class="small mb-0" style="color:#6B7280;">Kelola dan pantau data mahasiswa SIMADE</p>
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

    <div class="mahasiswa-index">
        <style>
            .mahasiswa-index {
                --green: #16a34a;
                --green-ring: rgba(22, 163, 74, 0.25);
                --gray-50: #f8fafc;
                --gray-100: #f1f5f9;
                --gray-200: #e5e7eb;
                --gray-300: #d1d5db;
                --gray-400: #9ca3af;
                --gray-500: #6b7280;
                --gray-600: #475569;
                --gray-700: #334155;
                --gray-800: #1f2937;
                --gray-900: #111827;
                --slate-500: #64748b;
                --white: #fff;
            }

            .mahasiswa-index .card {
                box-shadow: none !important;
                border: none !important;
                background: transparent !important;
            }

            .mahasiswa-index .filter-panel {
                background: var(--white);
                border: 1px solid var(--gray-200);
                border-radius: 12px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
                padding: 20px 24px;
                margin-bottom: 16px;
            }

            .mahasiswa-index .filter-panel .form-label {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #64748b;
                font-weight: 600;
                margin-bottom: 0.4rem;
            }

            .mahasiswa-index .filter-panel .form-control,
            .mahasiswa-index .filter-panel .form-select {
                background: var(--white);
                border: 1px solid var(--gray-300);
                color: var(--gray-900);
                height: 46px;
                border-radius: 10px;
                font-size: 14px;
                padding: 0 12px;
                width: 100%;
                min-width: 0;
                transition: border-color 0.15s ease, box-shadow 0.15s ease;
            }

            .mahasiswa-index .filter-panel .form-control::placeholder,
            .mahasiswa-index .filter-panel .form-select::placeholder {
                color: var(--gray-400);
            }

            .mahasiswa-index .filter-panel .form-control:focus,
            .mahasiswa-index .filter-panel .form-select:focus {
                border-color: var(--green);
                box-shadow: 0 0 0 3px var(--green-ring);
                outline: none;
            }

            /* Perbaiki dropdown filter: panah kustom, padding kanan, lebar aman */
            .mahasiswa-index .filter-panel .form-select,
            .mahasiswa-index .filter-panel select.form-control {
                background-repeat: no-repeat;
                background-position: right 0.75rem center;
                background-size: 16px 12px;
                padding-right: 2.25rem;      /* ruang untuk panah */
                min-width: 0;                /* pastikan tidak overflow/overlap */
                width: 100%;
                -webkit-appearance: none;
                appearance: none;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            }

            .mahasiswa-index .filter-actions {
                display: flex;
                gap: 0.5rem;
                align-items: center;
            }

            .mahasiswa-index .btn-filter {
                background: var(--green);
                border-color: var(--green);
                color: var(--white);
                font-weight: 600;
                height: 42px;
                min-width: 110px;
                border-radius: 8px;
                padding: 0 16px;
                font-size: 13px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: background-color 0.15s ease, border-color 0.15s ease;
            }

            .mahasiswa-index .btn-filter:hover,
            .mahasiswa-index .btn-filter:focus {
                background: #15803d;
                border-color: #15803d;
                color: var(--white);
            }

            .mahasiswa-index .btn-reset {
                background: transparent;
                border: 1px solid var(--gray-600);
                color: var(--gray-600);
                font-weight: 600;
                height: 42px;
                min-width: 110px;
                border-radius: 8px;
                padding: 0 16px;
                font-size: 13px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease;
            }

            .mahasiswa-index .btn-reset:hover,
            .mahasiswa-index .btn-reset:focus {
                background: var(--gray-600);
                border-color: var(--gray-600);
                color: var(--white);
            }

            .mahasiswa-index .data-count-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 10px 16px;
                background: transparent;
                border-bottom: 1px solid var(--gray-200);
                flex-wrap: wrap;
            }

            .mahasiswa-index .data-count-bar .count-text {
                font-size: 14px;
                color: var(--gray-600);
            }

            .mahasiswa-index .data-count-bar .count-text strong {
                color: var(--gray-800);
                font-weight: 600;
            }

            .mahasiswa-index .data-count-bar .clear-filters {
                font-size: 13px;
                color: #dc2626;
                text-decoration: none;
                font-weight: 500;
                padding: 4px 8px;
                border-radius: 6px;
                transition: background-color 0.15s ease;
            }

            .mahasiswa-index .data-count-bar .clear-filters:hover {
                background: rgba(220, 38, 38, 0.1);
                text-decoration: none;
            }

            .mahasiswa-index .table-responsive {
                overflow-x: auto;
            }

            .mahasiswa-index table {
                width: 100%;
                border-collapse: collapse;
                background: var(--white);
            }

            .mahasiswa-index thead th {
                background: var(--gray-50);
                color: var(--gray-600);
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.03em;
                padding: 12px 16px;
                border-bottom: 1px solid var(--gray-200);
                white-space: nowrap;
            }

            .mahasiswa-index tbody td {
                color: var(--gray-800);
                padding: 12px 16px;
                border-bottom: 1px solid var(--gray-100);
                vertical-align: middle;
                font-size: 14px;
            }

            .mahasiswa-index tbody tr:last-child td {
                border-bottom: none;
            }

            .mahasiswa-index tbody tr:hover td {
                background: var(--gray-50);
            }

            .mahasiswa-index .nim-cell {
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
                color: var(--gray-700);
                white-space: nowrap;
            }

            .mahasiswa-index .name-cell {
                font-weight: 500;
                white-space: nowrap;
            }

            .mahasiswa-index .badge-jenjang {
                display: inline-flex;
                align-items: center;
                padding: 4px 10px;
                font-size: 12px;
                font-weight: 500;
                border-radius: 9999px;
                background: #e0f2fe;
                color: #0369a1;
                border: 1px solid #bae6fd;
            }

            .mahasiswa-index .badge-status-aktif {
                background: #dcfce7;
                color: #166534;
                border: 1px solid #bbf7d0;
            }

            .mahasiswa-index .badge-status-cuti {
                background: #fef9c3;
                color: #854d0e;
                border: 1px solid #fde047;
            }

            .mahasiswa-index .badge-status-nonaktif {
                background: #fee2e2;
                color: #991b1b;
                border: 1px solid #fca5a5;
            }

            .mahasiswa-index .action-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 32px;
                height: 32px;
                border-radius: 6px;
                border: 1px solid var(--gray-300);
                background: transparent;
                color: var(--gray-600);
                transition: all 0.15s ease;
                text-decoration: none;
            }

            .mahasiswa-index .action-btn:hover,
            .mahasiswa-index .action-btn:focus {
                background: var(--gray-100);
                border-color: var(--gray-400);
                color: var(--gray-800);
                text-decoration: none;
            }

            .mahasiswa-index .action-btn.view:hover,
            .mahasiswa-index .action-btn.view:focus {
                background: #e0f2fe;
                border-color: #bae6fd;
                color: #0369a1;
            }

            .mahasiswa-index .action-btn.edit:hover,
            .mahasiswa-index .action-btn.edit:focus {
                background: #dcfce7;
                border-color: #bbf7d0;
                color: #166534;
            }

            .mahasiswa-index .action-btn.delete:hover,
            .mahasiswa-index .action-btn.delete:focus {
                background: #fee2e2;
                border-color: #fca5a5;
                color: #991b1b;
            }

            .mahasiswa-index .action-btn i {
                font-size: 14px;
            }

            .mahasiswa-index .btn-group-sm .btn {
                padding: 0;
            }

            .mahasiswa-index .pagination {
                margin: 0;
            }

            .mahasiswa-index .page-link {
                color: var(--gray-700);
                border-color: var(--gray-200);
                background: var(--white);
                padding: 8px 12px;
                margin: 0 2px;
                border-radius: 6px;
            }

            .mahasiswa-index .page-link:hover {
                background: var(--gray-100);
                border-color: var(--gray-300);
                color: var(--gray-900);
            }

            .mahasiswa-index .page-item.active .page-link {
                background: var(--green);
                border-color: var(--green);
                color: var(--white);
            }

            .mahasiswa-index .page-item.disabled .page-link {
                color: var(--gray-400);
                background: var(--white);
                border-color: var(--gray-200);
            }

            @media (max-width: 768px) {
                .mahasiswa-index .filter-panel {
                    padding: 16px;
                }

                .mahasiswa-index thead th,
                .mahasiswa-index tbody td {
                    padding: 10px 12px;
                    font-size: 13px;
                }

                .mahasiswa-index .data-count-bar {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 8px;
                }
            }

            .mahasiswa-index .jenjang-col { min-width: 100px; }
            .mahasiswa-index .semester-col { min-width: 80px; }
            .mahasiswa-index .status-col { min-width: 110px; }
            .mahasiswa-index .aksi-col { min-width: 120px; white-space: nowrap; }
        </style>

        {{-- Filter Panel --}}
        <div class="filter-panel">
            <form method="GET" action="{{ route('mahasiswa.index') }}" class="row g-3 align-items-end">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <label class="form-label" for="search">Cari NIM / Nama</label>
                    <input id="search" type="text" name="search" placeholder="Cari..." value="{{ request('search') }}" class="form-control form-control-sm"/>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <label class="form-label" for="fakultas">Fakultas</label>
                    <select id="fakultas" name="fakultas" class="form-select form-select-sm" onchange="updateProdi(this.value)">
                        <option value="">Semua Fakultas</option>
                        @foreach(array_keys($daftarFakultas) as $fak)
                            <option value="{{ $fak }}" {{ request('fakultas') == $fak ? 'selected' : '' }}>{{ $fak }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <label class="form-label" for="prodiSelect">Program Studi</label>
                    <select name="program_studi" id="prodiSelect" class="form-select form-select-sm">
                        <option value="">Semua Prodi</option>
                        @foreach($daftarProdi as $prodi)
                            <option value="{{ $prodi }}" {{ request('program_studi') == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3 col-lg-1">
                    <label class="form-label" for="jenjang">Jenjang</label>
                    <select id="jenjang" name="jenjang" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach(['D3','S1','S2','S3'] as $j)
                            <option value="{{ $j }}" {{ request('jenjang') == $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <label class="form-label" for="semester">Semester</label>
                    <select id="semester" name="semester" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @for($s=1; $s<=14; $s++)
                            <option value="{{ $s }}" {{ request('semester') == $s ? 'selected' : '' }}>Sem {{ $s }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <label class="form-label" for="status">Status</label>
                    <select id="status" name="status" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="Cuti" {{ request('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                    </select>
                </div>

                <div class="col-12 d-flex gap-2 filter-actions">
                    <button type="submit" class="btn btn-filter btn-sm"><i class="bi bi-funnel me-1"></i>Filter</button>
                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-reset btn-sm">Reset</a>
                </div>
            </form>
        </div>

        {{-- Info hasil filter --}}
        <div class="data-count-bar">
            <span class="count-text">Menampilkan <strong>{{ $mahasiswas->total() }}</strong> mahasiswa</span>
            @if(request()->hasAny(['search','status','fakultas','program_studi','jenjang','semester','jenis_kelamin']))
                <a href="{{ route('mahasiswa.index') }}" class="clear-filters">Hapus semua filter</a>
            @endif
        </div>

        {{-- Tabel --}}
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>Fakultas</th>
                        <th>Program Studi</th>
                        <th class="jenjang-col">Jenjang</th>
                        <th class="semester-col text-center">Sem</th>
                        <th>Tahun Akademik</th>
                        <th class="status-col">Status</th>
                        <th class="aksi-col text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswas as $mhs)
                    <tr>
                        <td class="nim-cell">{{ $mhs->nim }}</td>
                        <td class="name-cell">{{ $mhs->nama }}</td>
                        <td class="text-nowrap">{{ $mhs->jenis_kelamin ?? '-' }}</td>
                        <td title="{{ $mhs->fakultas }}">{{ $mhs->fakultas ?? '-' }}</td>
                        <td title="{{ $mhs->program_studi }}">{{ $mhs->program_studi ?? '-' }}</td>
                        <td><span class="badge-jenjang">{{ $mhs->jenjang }}</span></td>
                        <td class="text-center">{{ $mhs->semester ?? '-' }}</td>
                        <td class="text-nowrap">{{ $mhs->tahun_akademik ?? '-' }}</td>
                        <td>
                            @if($mhs->status == 'Aktif')
                                <span class="badge-jenjang badge-status-aktif">Aktif</span>
                            @elseif($mhs->status == 'Cuti')
                                <span class="badge-jenjang badge-status-cuti">Cuti</span>
                            @else
                                <span class="badge-jenjang badge-status-nonaktif">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center" role="group" aria-label="Aksi mahasiswa">
                                <a href="{{ route('mahasiswa.show', $mhs->id) }}" class="action-btn view" title="Detail" aria-label="Detail {{ $mhs->nama }}"><i class="bi bi-eye"></i></a>
                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('mahasiswa.edit', $mhs->id) }}" class="action-btn edit" title="Edit" aria-label="Edit {{ $mhs->nama }}"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data {{ addslashes($mhs->nama) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Hapus" aria-label="Hapus {{ $mhs->nama }}"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="py-5 text-center" style="color:var(--gray-500);">
                            <i class="bi bi-search" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                            Data tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($mahasiswas->hasPages())
            <div class="card-footer bg-white border-top" style="padding:16px 24px;background:var(--white);border-top:1px solid var(--gray-200);">
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