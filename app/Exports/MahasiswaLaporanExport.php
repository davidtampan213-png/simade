<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaLaporanExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function title(): string
    {
        return 'Laporan Mahasiswa';
    }

    public function query()
    {
        $query = Mahasiswa::query();
        if (!empty($this->filters['tahunAkademik'])) {
            $query->where('tahun_akademik', $this->filters['tahunAkademik']);
        }
        if (!empty($this->filters['semester'])) {
            $query->where('semester', $this->filters['semester']);
        }
        if (!empty($this->filters['fakultas'])) {
            $query->where('fakultas', $this->filters['fakultas']);
        }
        if (!empty($this->filters['prodi'])) {
            $query->where('program_studi', $this->filters['prodi']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        return $query->orderBy('fakultas')->orderBy('program_studi')->orderBy('nama');
    }

    public function headings(): array
    {
        return [
            'No', 'NIM', 'Nama', 'Jenis Kelamin', 'Fakultas',
            'Program Studi', 'Jenjang', 'Semester', 'Tahun Akademik', 'Status',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->nim,
            $row->nama,
            $row->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
            $row->fakultas ?? '-',
            $row->program_studi ?? '-',
            $row->jenjang,
            $row->semester,
            $row->tahun_akademik,
            $row->status,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
