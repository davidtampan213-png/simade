<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Mahasiswa::query();
        foreach ($this->filters as $key => $value) {
            if ($value) {
                $query->where($key, $value);
            }
        }
        return $query->orderBy('nama');
    }

    public function headings(): array
    {
        return [
            'No', 'NIM', 'Nama', 'Jenis Kelamin', 'Fakultas',
            'Program Studi', 'Jenjang', 'Semester', 'Tahun Akademik',
            'Status', 'Jenis Kelas', 'No HP', 'Alamat',
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
            $row->jenis_kelas,
            $row->no_hp ?? '-',
            $row->alamat ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
