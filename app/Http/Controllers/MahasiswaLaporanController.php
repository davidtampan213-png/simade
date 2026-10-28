<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\MahasiswaStatusHistory;
use Barryvdh\DomPDF\Facade\Pdf;

class MahasiswaLaporanController extends Controller
{
    private function getCurrentTahunAkademik(): string
    {
        $year = date('Y');
        $month = date('n');
        return $month >= 7 ? $year . '/' . ($year + 1) : ($year - 1) . '/' . $year;
    }

    /**
     * Laporan utama: statistik per fakultas
     */
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun_akademik', $this->getCurrentTahunAkademik());
        $semester      = $request->get('semester', '');

        $query = Mahasiswa::query();
        if ($tahunAkademik) {
            $query->where('tahun_akademik', $tahunAkademik);
        }
        if ($semester) {
            $query->where('semester', $semester);
        }

        // Statistik per fakultas
        $statsPerFakultas = $query->selectRaw('
            fakultas,
            COUNT(*) as total,
            SUM(CASE WHEN status = "Aktif" THEN 1 ELSE 0 END) as aktif,
            SUM(CASE WHEN status = "Nonaktif" THEN 1 ELSE 0 END) as nonaktif,
            SUM(CASE WHEN status = "Cuti" THEN 1 ELSE 0 END) as cuti
        ')
        ->whereNotNull('fakultas')
        ->groupBy('fakultas')
        ->orderBy('total', 'desc')
        ->get();

        // Statistik global (header)
        $globalQuery = Mahasiswa::query();
        if ($tahunAkademik) $globalQuery->where('tahun_akademik', $tahunAkademik);
        if ($semester)      $globalQuery->where('semester', $semester);

        $totalAll      = (clone $globalQuery)->count();
        $totalAktif    = (clone $globalQuery)->where('status', 'Aktif')->count();
        $totalNonaktif = (clone $globalQuery)->where('status', 'Nonaktif')->count();
        $totalCuti     = (clone $globalQuery)->where('status', 'Cuti')->count();

        // Daftar tahun akademik yang tersedia
        $tahunList = Mahasiswa::selectRaw('DISTINCT tahun_akademik')
                              ->whereNotNull('tahun_akademik')
                              ->orderBy('tahun_akademik', 'desc')
                              ->pluck('tahun_akademik');

        return view('mahasiswa.laporan', compact(
            'statsPerFakultas',
            'totalAll', 'totalAktif', 'totalNonaktif', 'totalCuti',
            'tahunAkademik', 'semester', 'tahunList'
        ));
    }

    /**
     * Detail laporan untuk satu fakultas (+ per prodi)
     */
    public function fakultas(Request $request, string $fakultas)
    {
        $tahunAkademik = $request->get('tahun_akademik', $this->getCurrentTahunAkademik());
        $semester      = $request->get('semester', '');
        $prodiFilter   = $request->get('program_studi', '');

        // Statistik header fakultas
        $baseQuery = Mahasiswa::where('fakultas', $fakultas);
        if ($tahunAkademik) $baseQuery->where('tahun_akademik', $tahunAkademik);
        if ($semester)      $baseQuery->where('semester', $semester);

        $totalAktif    = (clone $baseQuery)->where('status', 'Aktif')->count();
        $totalNonaktif = (clone $baseQuery)->where('status', 'Nonaktif')->count();
        $totalCuti     = (clone $baseQuery)->where('status', 'Cuti')->count();
        $totalAll      = $totalAktif + $totalNonaktif + $totalCuti;

        // Statistik per program studi
        $statsPerProdi = (clone $baseQuery)->selectRaw('
            program_studi,
            COUNT(*) as total,
            SUM(CASE WHEN status = "Aktif" THEN 1 ELSE 0 END) as aktif,
            SUM(CASE WHEN status = "Nonaktif" THEN 1 ELSE 0 END) as nonaktif,
            SUM(CASE WHEN status = "Cuti" THEN 1 ELSE 0 END) as cuti
        ')
        ->whereNotNull('program_studi')
        ->groupBy('program_studi')
        ->orderBy('total', 'desc')
        ->get();

        // Daftar mahasiswa (dengan filter prodi opsional)
        $listQuery = Mahasiswa::where('fakultas', $fakultas);
        if ($tahunAkademik) $listQuery->where('tahun_akademik', $tahunAkademik);
        if ($semester)      $listQuery->where('semester', $semester);
        if ($prodiFilter)   $listQuery->where('program_studi', $prodiFilter);

        $mahasiswas = $listQuery->orderBy('program_studi')->orderBy('nama')->paginate(20)->withQueryString();

        // Daftar prodi di fakultas ini
        $daftarProdi = Mahasiswa::where('fakultas', $fakultas)
                                ->whereNotNull('program_studi')
                                ->distinct()
                                ->pluck('program_studi');

        $tahunList = Mahasiswa::selectRaw('DISTINCT tahun_akademik')
                              ->whereNotNull('tahun_akademik')
                              ->orderBy('tahun_akademik', 'desc')
                              ->pluck('tahun_akademik');

        return view('mahasiswa.laporan_fakultas', compact(
            'fakultas',
            'statsPerProdi',
            'mahasiswas',
            'totalAktif', 'totalNonaktif', 'totalCuti', 'totalAll',
            'tahunAkademik', 'semester',
            'tahunList', 'daftarProdi', 'prodiFilter'
        ));
    }

    /**
     * Ekspor laporan (Excel / PDF)
     */
    public function export(Request $request)
    {
        $format        = $request->get('format', 'excel');
        $tahunAkademik = $request->get('tahun_akademik', '');
        $semester      = $request->get('semester', '');
        $fakultas      = $request->get('fakultas', '');
        $prodi         = $request->get('program_studi', '');
        $status        = $request->get('status', '');

        $filters  = compact('tahunAkademik', 'semester', 'fakultas', 'prodi', 'status');
        $query    = Mahasiswa::query();
        if ($tahunAkademik) $query->where('tahun_akademik', $tahunAkademik);
        if ($semester)      $query->where('semester', $semester);
        if ($fakultas)      $query->where('fakultas', $fakultas);
        if ($prodi)         $query->where('program_studi', $prodi);
        if ($status)        $query->where('status', $status);

        if ($format === 'pdf') {
            $mahasiswas = $query->orderBy('fakultas')->orderBy('program_studi')->orderBy('nama')->get();
            $pdf = Pdf::loadView('mahasiswa.export_pdf', compact('mahasiswas', 'filters'))
                      ->setPaper('a4', 'landscape');
            return $pdf->download('laporan-mahasiswa.pdf');
        }

        // Excel: ekspor sebagai CSV
        $mahasiswas = $query->orderBy('fakultas')->orderBy('program_studi')->orderBy('nama')->get();
        $filename   = 'laporan-mahasiswa-' . date('Ymd') . '.csv';
        $headers    = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($mahasiswas) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8
            fputcsv($out, ['No','NIM','Nama','Jenis Kelamin','Fakultas','Program Studi','Jenjang','Semester','Tahun Akademik','Status']);
            foreach ($mahasiswas as $i => $m) {
                fputcsv($out, [
                    $i + 1, $m->nim, $m->nama,
                    $m->jenis_kelamin === 'L' ? 'Laki-laki' : ($m->jenis_kelamin === 'P' ? 'Perempuan' : '-'),
                    $m->fakultas ?? '-', $m->program_studi ?? '-',
                    $m->jenjang, $m->semester, $m->tahun_akademik, $m->status,
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
