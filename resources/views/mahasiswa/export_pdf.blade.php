<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Mahasiswa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1f2937; }
        .header { background: #065f46; color: white; padding: 14px 20px; margin-bottom: 16px; }
        .header h1 { font-size: 16px; font-weight: bold; margin-bottom: 2px; }
        .header p { font-size: 10px; opacity: 0.8; }
        .filter-info { background: #ecfdf5; border: 1px solid #6ee7b7; border-radius: 4px; padding: 8px 12px; margin-bottom: 14px; font-size: 9px; color: #065f46; }
        .stats-row { display: flex; gap: 8px; margin-bottom: 16px; }
        .stat-box { flex: 1; border: 1px solid #d1fae5; border-radius: 4px; padding: 8px 10px; text-align: center; background: #f0fdf4; }
        .stat-box .num { font-size: 18px; font-weight: bold; color: #065f46; }
        .stat-box .lbl { font-size: 8px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
        table { width: 100%; border-collapse: collapse; font-size: 9px; }
        thead tr { background: #065f46; color: white; }
        thead th { padding: 7px 8px; text-align: left; font-weight: 600; font-size: 8px; text-transform: uppercase; }
        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody tr:nth-child(odd)  { background: #ffffff; }
        tbody td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; vertical-align: middle; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 10px; font-size: 8px; font-weight: bold; }
        .badge-aktif    { background: #d1fae5; color: #065f46; }
        .badge-nonaktif { background: #fee2e2; color: #991b1b; }
        .badge-cuti     { background: #fef3c7; color: #92400e; }
        .footer { margin-top: 20px; font-size: 8px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Data Mahasiswa — SIMADE</h1>
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    @if(!empty(array_filter($filters)))
    <div class="filter-info">
        Filter:
        @if(!empty($filters['tahunAkademik'])) Tahun Akademik: <strong>{{ $filters['tahunAkademik'] }}</strong> &nbsp; @endif
        @if(!empty($filters['semester']))      Semester: <strong>{{ $filters['semester'] }}</strong> &nbsp; @endif
        @if(!empty($filters['fakultas']))      Fakultas: <strong>{{ $filters['fakultas'] }}</strong> &nbsp; @endif
        @if(!empty($filters['prodi']))         Program Studi: <strong>{{ $filters['prodi'] }}</strong> &nbsp; @endif
        @if(!empty($filters['status']))        Status: <strong>{{ $filters['status'] }}</strong> @endif
    </div>
    @endif

    <div class="stats-row">
        @php
            $tot = $mahasiswas->count();
            $akt = $mahasiswas->where('status','Aktif')->count();
            $non = $mahasiswas->where('status','Nonaktif')->count();
            $cut = $mahasiswas->where('status','Cuti')->count();
        @endphp
        <div class="stat-box"><div class="num">{{ $tot }}</div><div class="lbl">Total</div></div>
        <div class="stat-box"><div class="num" style="color:#16a34a">{{ $akt }}</div><div class="lbl">Aktif</div></div>
        <div class="stat-box"><div class="num" style="color:#dc2626">{{ $non }}</div><div class="lbl">Nonaktif</div></div>
        <div class="stat-box"><div class="num" style="color:#d97706">{{ $cut }}</div><div class="lbl">Cuti</div></div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:3%">No</th>
                <th style="width:10%">NIM</th>
                <th style="width:18%">Nama</th>
                <th style="width:5%">JK</th>
                <th style="width:15%">Fakultas</th>
                <th style="width:15%">Program Studi</th>
                <th style="width:5%">Jenjang</th>
                <th style="width:5%">Sem</th>
                <th style="width:10%">Tahun Akademik</th>
                <th style="width:9%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mahasiswas as $i => $m)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $m->nim }}</td>
                <td>{{ $m->nama }}</td>
                <td>{{ $m->jenis_kelamin == 'L' ? 'L' : ($m->jenis_kelamin == 'P' ? 'P' : '-') }}</td>
                <td>{{ $m->fakultas ?? '-' }}</td>
                <td>{{ $m->program_studi ?? '-' }}</td>
                <td style="text-align:center">{{ $m->jenjang ?? '-' }}</td>
                <td style="text-align:center">{{ $m->semester ?? '-' }}</td>
                <td>{{ $m->tahun_akademik ?? '-' }}</td>
                <td>
                    @if($m->status=='Aktif')
                        <span class="badge badge-aktif">Aktif</span>
                    @elseif($m->status=='Cuti')
                        <span class="badge badge-cuti">Cuti</span>
                    @else
                        <span class="badge badge-nonaktif">Nonaktif</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="10" style="text-align:center;padding:20px;color:#9ca3af">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total {{ $mahasiswas->count() }} mahasiswa &bull; Dokumen ini digenerate otomatis oleh SIMADE
    </div>
</body>
</html>
