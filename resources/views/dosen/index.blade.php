<x-adminlte-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-sm-between gap-3">
            <h1 class="h3 mb-0 fw-bold" style="color: #0f172a;">Data Dosen</h1>
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

    <div class="dosen-index">
        <style>
            .dosen-index {
                --green: #16a34a;
                --green-ring: rgba(22, 163, 74, 0.25);
                --slate-50: #f8fafc;
                --slate-100: #f1f5f9;
                --slate-200: #e2e8f0;
                --slate-300: #cbd5e1;
                --slate-400: #94a3b8;
                --slate-500: #64748b;
                --slate-600: #475569;
                --slate-700: #334155;
                --slate-900: #0f172a;
                --white: #fff;
            }

            .dosen-index .card {
                background: var(--white);
                border: 1px solid var(--slate-200);
                border-radius: 14px;
                box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06);
                overflow: hidden;
            }

            .dosen-index .filter-panel {
                padding: 20px 24px;
                margin-bottom: 0;
                background: var(--white);
                border: 0;
                border-bottom: 1px solid var(--slate-200);
                border-radius: 0;
                box-shadow: none;
            }

            .dosen-index .form-label {
                margin-bottom: .4rem;
                color: var(--slate-500);
                font-size: .75rem;
                font-weight: 600;
                letter-spacing: .05em;
                text-transform: uppercase;
            }

            .dosen-index .form-control {
                height: 46px;
                padding: 0 12px;
                color: var(--slate-900);
                background: var(--white);
                border: 1px solid var(--slate-300);
                border-radius: 10px;
            }

            .dosen-index .form-control::placeholder { color: var(--slate-400); }
            .dosen-index .form-control:focus {
                border-color: var(--green);
                box-shadow: 0 0 0 3px var(--green-ring);
            }

            .dosen-index .filter-actions { display: flex; gap: .5rem; }
            .dosen-index .btn-filter,
            .dosen-index .btn-reset {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 110px;
                height: 46px;
                padding: 0 16px;
                border-radius: 8px;
                font-size: 13px;
                font-weight: 600;
            }
            .dosen-index .btn-filter { color: var(--white); background: var(--green); border-color: var(--green); }
            .dosen-index .btn-filter:hover, .dosen-index .btn-filter:focus { color: var(--white); background: #15803d; border-color: #15803d; }
            .dosen-index .btn-reset { color: var(--slate-700); background: var(--white); border: 1px solid var(--slate-500); }
            .dosen-index .btn-reset:hover, .dosen-index .btn-reset:focus { color: var(--white); background: var(--slate-600); border-color: var(--slate-600); }

            .dosen-index .table-card {
                background: var(--white);
                border: 0;
                border-radius: 0;
                overflow: hidden;
            }
            .dosen-index .table-responsive { overflow-x: visible; }
            .dosen-index .table-card .table {
                --bs-table-bg: #ffffff;
                --bs-table-color: #0f172a;
                --bs-table-striped-bg: #ffffff;
                --bs-table-striped-color: #0f172a;
                --bs-table-hover-bg: #f8fafc;
                --bs-table-hover-color: #0f172a;
                width: 100%;
                margin-bottom: 0;
                background: #ffffff;
                border-collapse: collapse;
            }
            .dosen-index .table-card .table > :not(caption) > * > * {
                box-shadow: none;
                border-left: 0;
                border-right: 0;
            }
            .dosen-index .table-card thead th {
                padding: .75rem .625rem;
                color: var(--slate-500);
                background: #f1f5f9;
                border-bottom: 1px solid var(--slate-200);
                font-size: .75rem;
                font-weight: 600;
                letter-spacing: .04em;
                text-transform: uppercase;
            }
            .dosen-index .table-card tbody tr,
            .dosen-index .table-card tbody td {
                background-color: #ffffff !important;
                color: #0f172a !important;
            }
            .dosen-index .table-card tbody td {
                padding: .9rem .625rem;
                border-bottom: 1px solid #eef2f6;
                font-size: .875rem;
                transition: background-color .15s ease;
            }
            .dosen-index .table-card tbody tr:hover td {
                background-color: #f8fafc !important;
            }
            .dosen-index .table-card tbody tr:last-child td { border-bottom: 0; }
            .dosen-index .nip-cell {
                color: #475569 !important;
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
                font-size: .875rem;
            }
            .dosen-index .name-cell { color: #0f172a !important; font-weight: 600 !important; }
            .dosen-index .detail-cell { color: #334155 !important; }
            .dosen-index .badge-status {
                display: inline-flex;
                padding: 4px 10px;
                border: 1px solid;
                border-radius: 9999px;
                font-size: .75rem;
                font-weight: 600;
            }
            .dosen-index .badge-status-aktif { color: #166534; background: #dcfce7; border-color: #bbf7d0; }
            .dosen-index .badge-status-nonaktif { color: #991b1b; background: #fee2e2; border-color: #fca5a5; }
            .dosen-index .aksi-col { width: 120px; white-space: nowrap; }
            .dosen-index .action-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 32px;
                height: 32px;
                padding: 0;
                color: var(--slate-600);
                background: var(--white);
                border: 1px solid var(--slate-300);
                border-radius: 6px;
                text-decoration: none;
            }
            .dosen-index .action-btn:hover, .dosen-index .action-btn:focus { color: var(--slate-900); background: var(--slate-100); border-color: var(--slate-400); }
            .dosen-index .action-btn.view:hover, .dosen-index .action-btn.view:focus { color: #0369a1; background: #e0f2fe; border-color: #bae6fd; }
            .dosen-index .action-btn.edit:hover, .dosen-index .action-btn.edit:focus { color: #166534; background: #dcfce7; border-color: #bbf7d0; }
            .dosen-index .action-btn.delete:hover, .dosen-index .action-btn.delete:focus { color: #991b1b; background: #fee2e2; border-color: #fca5a5; }
            .dosen-index .card-footer { color: var(--slate-500); background: var(--white); border-top: 1px solid var(--slate-200); }
            .dosen-index .card-footer, .dosen-index .card-footer * { color: var(--slate-500); }

            @media (max-width: 768px) {
                .dosen-index .filter-panel { padding: 16px; }
                .dosen-index .table-responsive { overflow-x: auto; }
                .dosen-index thead th, .dosen-index tbody td { padding: 10px 8px; font-size: .8125rem; }
            }
        </style>

        <div class="card">
            <div class="filter-panel mb-0 rounded-0 border-0 border-bottom">
                <form method="GET" action="{{ route('dosen.index') }}" class="row g-2 align-items-end">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="search" class="form-label">Cari NIP / Nama</label>
                        <input id="search" type="text" name="search" placeholder="Cari NIP/Nama" value="{{ request('search') }}" class="form-control">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3 filter-actions">
                        <button type="submit" class="btn btn-filter">Filter</button>
                        <a href="{{ route('dosen.index') }}" class="btn btn-reset">Reset</a>
                    </div>
                </form>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-nowrap">NIP</th>
                                <th class="text-nowrap">Nama</th>
                                <th class="text-nowrap">Jabatan</th>
                                <th class="text-nowrap">Prodi</th>
                                <th class="text-nowrap">Jurusan</th>
                                <th class="text-nowrap">Status</th>
                                <th class="aksi-col text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dosens as $dsn)
                            <tr>
                                <td class="nip-cell text-nowrap">{{ $dsn->nip }}</td>
                                <td class="name-cell text-nowrap">{{ $dsn->nama }}</td>
                                <td class="detail-cell text-nowrap">{{ $dsn->jabatan ?? '-' }}</td>
                                <td class="detail-cell text-nowrap">{{ $dsn->prodi ?? '-' }}</td>
                                <td class="detail-cell text-nowrap">{{ $dsn->jurusan }}</td>
                                <td class="text-nowrap">
                                    <span class="badge-status {{ $dsn->status === 'Aktif' ? 'badge-status-aktif' : 'badge-status-nonaktif' }}">{{ $dsn->status }}</span>
                                </td>
                                <td class="aksi-col text-center">
                                <div class="d-flex justify-content-center gap-1" role="group" aria-label="Aksi dosen">
                                    <a href="{{ route('dosen.show', $dsn->id) }}" class="action-btn view" title="Detail" aria-label="Detail {{ $dsn->nama }}"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('dosen.edit', $dsn->id) }}" class="action-btn edit" title="Edit" aria-label="Edit {{ $dsn->nama }}"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('dosen.destroy', $dsn->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Hapus" aria-label="Hapus {{ $dsn->nama }}"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5" style="color: var(--slate-500);">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>

            <div class="card-footer py-3">
                {{ $dosens->links() }}
            </div>
        </div>
    </div>
</x-adminlte-layout>
