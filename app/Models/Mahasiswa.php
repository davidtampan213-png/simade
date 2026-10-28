<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'nama',
        'jenis_kelamin',
        'fakultas',
        'program_studi',
        'jenjang',
        'semester',
        'tahun_akademik',
        'status',
        'jenis_kelas',
        'status_beasiswa',
        'alamat',
        'no_hp',
    ];

    // Daftar fakultas & prodi (digunakan di controller dan view)
    public static function daftarFakultas(): array
    {
        return [
            'Fakultas Teknik' => [
                'Teknik Informatika',
                'Teknik Mesin',
                'Teknik Sipil',
                'Arsitektur',
            ],
            'Fakultas Ekonomi & Bisnis' => [
                'Manajemen',
                'Akuntansi',
                'Ekonomi Pembangunan',
            ],
            'Fakultas Ilmu Komputer' => [
                'Sistem Informasi',
                'Manajemen Informatika',
                'Ilmu Komputer',
            ],
            'Fakultas Hukum' => [
                'Ilmu Hukum',
            ],
            'Fakultas Pertanian' => [
                'Agroteknologi',
                'Agribisnis',
            ],
        ];
    }

    // Daftar semua program studi (flat)
    public static function daftarProdi(): array
    {
        $all = [];
        foreach (self::daftarFakultas() as $prodi) {
            $all = array_merge($all, $prodi);
        }
        return $all;
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    public function scopeNonaktif($query)
    {
        return $query->where('status', 'Nonaktif');
    }

    public function scopeCuti($query)
    {
        return $query->where('status', 'Cuti');
    }

    public function scopeByFakultas($query, $fakultas)
    {
        return $query->where('fakultas', $fakultas);
    }

    public function scopeByProdi($query, $prodi)
    {
        return $query->where('program_studi', $prodi);
    }

    // Relasi
    public function statusHistories()
    {
        return $this->hasMany(MahasiswaStatusHistory::class);
    }

    // Helper untuk label jenis kelamin
    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : ($this->jenis_kelamin === 'P' ? 'Perempuan' : '-');
    }
}
