<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Penelitian;
use App\Models\Pembelajaran;
use App\Models\KinerjaDosen;

class DashboardController extends Controller
{
    private function getCurrentTahunAkademik(): string
    {
        $year = date('Y');
        $month = date('n');
        return $month >= 7 ? $year . '/' . ($year + 1) : ($year - 1) . '/' . $year;
    }

    public function mahasiswa(Request $request)
    {
        $tahunAkademik = $request->get('tahun_akademik', $this->getCurrentTahunAkademik());
        $semester      = $request->get('semester', '');

        $baseQuery = Mahasiswa::query();
        if ($tahunAkademik) {
            $baseQuery->where('tahun_akademik', $tahunAkademik);
        }
        if ($semester) {
            $baseQuery->where('semester', $semester);
        }

        $totalMahasiswaAktif    = (clone $baseQuery)->where('status', 'Aktif')->count();
        $totalMahasiswaNonaktif = (clone $baseQuery)->where('status', 'Nonaktif')->count();
        $totalMahasiswaCuti     = (clone $baseQuery)->where('status', 'Cuti')->count();
        $totalMahasiswa         = $totalMahasiswaAktif + $totalMahasiswaNonaktif + $totalMahasiswaCuti;

        // Statistik per jurusan/program_studi
        $mahasiswaPerJurusan = (clone $baseQuery)
            ->selectRaw('COALESCE(program_studi, jurusan) as label, COUNT(*) as total')
            ->groupByRaw('COALESCE(program_studi, jurusan)')
            ->orderBy('total', 'desc')
            ->get();

        // Statistik per status untuk chart donut
        $mahasiswaPerStatus = [
            ['status' => 'Aktif',    'total' => $totalMahasiswaAktif],
            ['status' => 'Nonaktif', 'total' => $totalMahasiswaNonaktif],
            ['status' => 'Cuti',     'total' => $totalMahasiswaCuti],
        ];

        // Statistik per fakultas (diagregasi langsung dalam 1 query efisien)
        $mahasiswaPerFakultas = (clone $baseQuery)
            ->selectRaw('
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

        // Daftar tahun akademik untuk filter
        $tahunList = Mahasiswa::selectRaw('DISTINCT tahun_akademik')
                              ->whereNotNull('tahun_akademik')
                              ->orderBy('tahun_akademik', 'desc')
                              ->pluck('tahun_akademik');

        return view('dashboard.mahasiswa', compact(
            'totalMahasiswa',
            'totalMahasiswaAktif',
            'totalMahasiswaNonaktif',
            'totalMahasiswaCuti',
            'mahasiswaPerJurusan',
            'mahasiswaPerStatus',
            'mahasiswaPerFakultas',
            'tahunAkademik',
            'semester',
            'tahunList'
        ));
    }

    public function dosen()
    {
        $totalDosenAktif = Dosen::where('status', 'Aktif')->count();
        $totalDosenNonaktif = Dosen::where('status', 'Nonaktif')->count();
        $totalDosen = $totalDosenAktif + $totalDosenNonaktif;

        $totalPenelitian  = Penelitian::count();
        $totalPembelajaran = Pembelajaran::count();
        $totalSks = Pembelajaran::sum('sks');

        $dosenPerJurusan = Dosen::selectRaw('jurusan, count(*) as total')
            ->groupBy('jurusan')
            ->get();

        $dosenPerStatus = Dosen::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->get();

        $dosenPerJabatan = Dosen::whereNotNull('jabatan')
            ->selectRaw('jabatan, count(*) as total')
            ->groupBy('jabatan')
            ->get();

        $kinerjaPerKategori = KinerjaDosen::selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->get();

        return view('dashboard.dosen', compact(
            'totalDosen',
            'totalDosenAktif',
            'totalDosenNonaktif',
            'totalPenelitian',
            'totalPembelajaran',
            'totalSks',
            'dosenPerJurusan',
            'dosenPerStatus',
            'dosenPerJabatan',
            'kinerjaPerKategori'
        ));
    }
}
