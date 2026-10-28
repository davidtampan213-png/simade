<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\MahasiswaStatusHistory;
use Barryvdh\DomPDF\Facade\Pdf;

class MahasiswaController extends Controller
{
    // Daftar jurusan yang masih valid untuk backward compat
    private function getDaftarFakultas(): array
    {
        return Mahasiswa::daftarFakultas();
    }

    private function getCurrentTahunAkademik(): string
    {
        $year = date('Y');
        $month = date('n');
        // Semester Ganjil: Juli–Desember, Semester Genap: Jan–Juni
        if ($month >= 7) {
            return $year . '/' . ($year + 1);
        } else {
            return ($year - 1) . '/' . $year;
        }
    }

    private function getCurrentSemesterLabel(): string
    {
        $month = date('n');
        return $month >= 7 ? 'Ganjil' : 'Genap';
    }

    public function index(Request $request)
    {
        $query = Mahasiswa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nim', 'like', '%' . $search . '%');
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('jenis_kelas')) {
            $query->where('jenis_kelas', $request->jenis_kelas);
        }
        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }
        if ($request->filled('program_studi')) {
            $query->where('program_studi', $request->program_studi);
        }
        if ($request->filled('jenjang')) {
            $query->where('jenjang', $request->jenjang);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $mahasiswas = $query->orderBy('nama')->paginate(15)->withQueryString();

        $daftarFakultas = Mahasiswa::daftarFakultas();
        $daftarProdi = Mahasiswa::daftarProdi();

        return view('mahasiswa.index', compact('mahasiswas', 'daftarFakultas', 'daftarProdi'));
    }

    public function create()
    {
        $daftarFakultas = Mahasiswa::daftarFakultas();
        $tahunAkademikSekarang = $this->getCurrentTahunAkademik();
        return view('mahasiswa.create', compact('daftarFakultas', 'tahunAkademikSekarang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim'           => 'required|unique:mahasiswas,nim|max:20',
            'nama'          => 'required|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'fakultas'      => 'required|string|max:100',
            'program_studi' => 'required|string|max:100',
            'jenjang'       => 'required|in:D3,S1,S2,S3',
            'semester'      => 'required|integer|min:1|max:14',
            'tahun_akademik'=> 'required|string|max:20',
            'status'        => 'required|in:Aktif,Nonaktif,Cuti',
            'jenis_kelas'   => 'required|in:Reguler,Ekstensi',
            'status_beasiswa'=> 'boolean',
            'alamat'        => 'nullable|string',
            'no_hp'         => 'nullable|string|max:20',
        ]);

        $validated['status_beasiswa'] = $request->has('status_beasiswa');

        $mahasiswa = Mahasiswa::create($validated);

        // Catat riwayat status
        MahasiswaStatusHistory::updateOrCreate(
            [
                'mahasiswa_id'   => $mahasiswa->id,
                'semester'       => $validated['semester'],
                'tahun_akademik' => $validated['tahun_akademik'],
            ],
            ['status' => $validated['status']]
        );

        return redirect()->route('mahasiswa.index')->with('success', 'Data Mahasiswa berhasil ditambahkan.');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $riwayat = $mahasiswa->statusHistories()->orderBy('tahun_akademik', 'desc')->orderBy('semester', 'desc')->get();
        return view('mahasiswa.show', compact('mahasiswa', 'riwayat'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $daftarFakultas = Mahasiswa::daftarFakultas();
        return view('mahasiswa.edit', compact('mahasiswa', 'daftarFakultas'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nim'           => 'required|max:20|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama'          => 'required|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'fakultas'      => 'required|string|max:100',
            'program_studi' => 'required|string|max:100',
            'jenjang'       => 'required|in:D3,S1,S2,S3',
            'semester'      => 'required|integer|min:1|max:14',
            'tahun_akademik'=> 'required|string|max:20',
            'status'        => 'required|in:Aktif,Nonaktif,Cuti',
            'jenis_kelas'   => 'required|in:Reguler,Ekstensi',
            'status_beasiswa'=> 'boolean',
            'alamat'        => 'nullable|string',
            'no_hp'         => 'nullable|string|max:20',
        ]);

        $validated['status_beasiswa'] = $request->has('status_beasiswa');

        $mahasiswa->update($validated);

        // Perbarui/tambahkan riwayat status untuk semester ini
        MahasiswaStatusHistory::updateOrCreate(
            [
                'mahasiswa_id'   => $mahasiswa->id,
                'semester'       => $validated['semester'],
                'tahun_akademik' => $validated['tahun_akademik'],
            ],
            ['status' => $validated['status']]
        );

        return redirect()->route('mahasiswa.index')->with('success', 'Data Mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Data Mahasiswa berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $format  = $request->get('format', 'excel');
        $filters = $request->only(['status','fakultas','program_studi','semester','tahun_akademik','jenjang','jenis_kelamin']);
        $query   = $this->buildExportQuery($filters);

        if ($format === 'pdf') {
            $mahasiswas = $query->orderBy('nama')->get();
            $pdf = Pdf::loadView('mahasiswa.export_pdf', ['mahasiswas' => $mahasiswas, 'filters' => $filters])
                      ->setPaper('a4', 'landscape');
            return $pdf->download('laporan-mahasiswa.pdf');
        }

        // Excel: ekspor sebagai CSV (kompatibel semua versi Excel)
        $mahasiswas = $query->orderBy('nama')->get();
        $filename   = 'laporan-mahasiswa-' . date('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($mahasiswas) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8
            fputcsv($out, ['No','NIM','Nama','Jenis Kelamin','Fakultas','Program Studi','Jenjang','Semester','Tahun Akademik','Status','Jenis Kelas','No HP','Alamat']);
            foreach ($mahasiswas as $i => $m) {
                fputcsv($out, [
                    $i + 1, $m->nim, $m->nama,
                    $m->jenis_kelamin === 'L' ? 'Laki-laki' : ($m->jenis_kelamin === 'P' ? 'Perempuan' : '-'),
                    $m->fakultas ?? '-', $m->program_studi ?? '-',
                    $m->jenjang, $m->semester, $m->tahun_akademik,
                    $m->status, $m->jenis_kelas, $m->no_hp ?? '-', $m->alamat ?? '-',
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function buildExportQuery(array $filters)
    {
        $query = Mahasiswa::query();
        foreach ($filters as $key => $value) {
            if ($value) {
                $query->where($key, $value);
            }
        }
        return $query;
    }
}
