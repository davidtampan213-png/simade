<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Dosen
        User::create([
            'name' => 'Dosen Pembimbing',
            'email' => 'dosen@dosen.com',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        // Dummy Dosen
        \App\Models\Dosen::create([
            'nip' => '198501152010121001',
            'nama' => 'Dr. Ir. Budi Raharjo, M.T.',
            'prodi' => 'Teknik Informatika',
            'jurusan' => 'Teknik Informatika',
            'jabatan' => 'Lektor Kepala',
            'no_hp' => '08111222333',
            'alamat' => 'Jl. Setiabudi No. 12',
            'status' => 'Aktif'
        ]);

        \App\Models\Dosen::create([
            'nip' => '198803202015042002',
            'nama' => 'Prof. Dr. Siti Aminah, S.E., M.Si.',
            'prodi' => 'Manajemen',
            'jurusan' => 'Manajemen',
            'jabatan' => 'Guru Besar',
            'no_hp' => '081234567891',
            'alamat' => 'Jl. Diponegoro No. 45',
            'status' => 'Aktif'
        ]);

        // Sample Mahasiswa Dataset
        $mahasiswas = [
            // Fakultas Teknik - Teknik Informatika
            [
                'nim' => '220101001', 'nama' => 'Aditya Pratama', 'jenis_kelamin' => 'L',
                'fakultas' => 'Fakultas Teknik', 'program_studi' => 'Teknik Informatika', 'jurusan' => 'Teknik Informatika',
                'jenjang' => 'S1', 'semester' => 5, 'tahun_akademik' => '2026/2027', 'status' => 'Aktif',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => true, 'alamat' => 'Jl. Kaliurang KM 5', 'no_hp' => '08121111001'
            ],
            [
                'nim' => '220101002', 'nama' => 'Bella Safira', 'jenis_kelamin' => 'P',
                'fakultas' => 'Fakultas Teknik', 'program_studi' => 'Teknik Informatika', 'jurusan' => 'Teknik Informatika',
                'jenjang' => 'S1', 'semester' => 5, 'tahun_akademik' => '2026/2027', 'status' => 'Aktif',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => false, 'alamat' => 'Jl. Gejayan No. 14', 'no_hp' => '08121111002'
            ],
            [
                'nim' => '210101015', 'nama' => 'Cahyo Wibowo', 'jenis_kelamin' => 'L',
                'fakultas' => 'Fakultas Teknik', 'program_studi' => 'Teknik Informatika', 'jurusan' => 'Teknik Informatika',
                'jenjang' => 'S1', 'semester' => 7, 'tahun_akademik' => '2026/2027', 'status' => 'Cuti',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => false, 'alamat' => 'Jl. Magelang KM 7', 'no_hp' => '08121111003'
            ],
            [
                'nim' => '200101020', 'nama' => 'Dimas Arya', 'jenis_kelamin' => 'L',
                'fakultas' => 'Fakultas Teknik', 'program_studi' => 'Teknik Informatika', 'jurusan' => 'Teknik Informatika',
                'jenjang' => 'S1', 'semester' => 9, 'tahun_akademik' => '2026/2027', 'status' => 'Nonaktif',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => false, 'alamat' => 'Jl. Palagan KM 9', 'no_hp' => '08121111004'
            ],

            // Fakultas Teknik - Teknik Mesin & Sipil
            [
                'nim' => '220102001', 'nama' => 'Eka Saputra', 'jenis_kelamin' => 'L',
                'fakultas' => 'Fakultas Teknik', 'program_studi' => 'Teknik Mesin', 'jurusan' => 'Teknik Mesin',
                'jenjang' => 'S1', 'semester' => 5, 'tahun_akademik' => '2026/2027', 'status' => 'Aktif',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => false, 'alamat' => 'Jl. Solo KM 8', 'no_hp' => '08121111005'
            ],
            [
                'nim' => '230103001', 'nama' => 'Fajar Pratama', 'jenis_kelamin' => 'L',
                'fakultas' => 'Fakultas Teknik', 'program_studi' => 'Teknik Sipil', 'jurusan' => 'Teknik Sipil',
                'jenjang' => 'S1', 'semester' => 3, 'tahun_akademik' => '2026/2027', 'status' => 'Aktif',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => false, 'alamat' => 'Jl. Monjali No. 88', 'no_hp' => '08121111006'
            ],

            // Fakultas Ilmu Komputer - Sistem Informasi
            [
                'nim' => '220301001', 'nama' => 'Gita Gutawa', 'jenis_kelamin' => 'P',
                'fakultas' => 'Fakultas Ilmu Komputer', 'program_studi' => 'Sistem Informasi', 'jurusan' => 'Sistem Informasi',
                'jenjang' => 'S1', 'semester' => 5, 'tahun_akademik' => '2026/2027', 'status' => 'Aktif',
                'jenis_kelas' => 'Ekstensi', 'status_beasiswa' => true, 'alamat' => 'Jl. Bantul No. 12', 'no_hp' => '08121111007'
            ],
            [
                'nim' => '230301005', 'nama' => 'Hendra Kusuma', 'jenis_kelamin' => 'L',
                'fakultas' => 'Fakultas Ilmu Komputer', 'program_studi' => 'Sistem Informasi', 'jurusan' => 'Sistem Informasi',
                'jenjang' => 'S1', 'semester' => 3, 'tahun_akademik' => '2026/2027', 'status' => 'Cuti',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => false, 'alamat' => 'Jl. Kusumanegara No. 4', 'no_hp' => '08121111008'
            ],

            // Fakultas Ekonomi & Bisnis - Manajemen
            [
                'nim' => '220201001', 'nama' => 'Indah Permatasari', 'jenis_kelamin' => 'P',
                'fakultas' => 'Fakultas Ekonomi & Bisnis', 'program_studi' => 'Manajemen', 'jurusan' => 'Manajemen',
                'jenjang' => 'S1', 'semester' => 5, 'tahun_akademik' => '2026/2027', 'status' => 'Aktif',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => true, 'alamat' => 'Jl. Affandi No. 25', 'no_hp' => '08121111009'
            ],
            [
                'nim' => '220201002', 'nama' => 'Joko Susilo', 'jenis_kelamin' => 'L',
                'fakultas' => 'Fakultas Ekonomi & Bisnis', 'program_studi' => 'Manajemen', 'jurusan' => 'Manajemen',
                'jenjang' => 'S1', 'semester' => 5, 'tahun_akademik' => '2026/2027', 'status' => 'Aktif',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => false, 'alamat' => 'Jl. Glagahsari No. 10', 'no_hp' => '08121111010'
            ],
            [
                'nim' => '210201018', 'nama' => 'Kevin Sanjaya', 'jenis_kelamin' => 'L',
                'fakultas' => 'Fakultas Ekonomi & Bisnis', 'program_studi' => 'Manajemen', 'jurusan' => 'Manajemen',
                'jenjang' => 'S1', 'semester' => 7, 'tahun_akademik' => '2026/2027', 'status' => 'Nonaktif',
                'jenis_kelas' => 'Ekstensi', 'status_beasiswa' => false, 'alamat' => 'Jl. Gambiran No. 7', 'no_hp' => '08121111011'
            ],

            // Fakultas Ekonomi & Bisnis - Akuntansi
            [
                'nim' => '230202001', 'nama' => 'Larasati Dewi', 'jenis_kelamin' => 'P',
                'fakultas' => 'Fakultas Ekonomi & Bisnis', 'program_studi' => 'Akuntansi', 'jurusan' => 'Akuntansi',
                'jenjang' => 'S1', 'semester' => 3, 'tahun_akademik' => '2026/2027', 'status' => 'Aktif',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => true, 'alamat' => 'Jl. Colombo No. 1', 'no_hp' => '08121111012'
            ],
            [
                'nim' => '220202012', 'nama' => 'Muhammad Rizky', 'jenis_kelamin' => 'L',
                'fakultas' => 'Fakultas Ekonomi & Bisnis', 'program_studi' => 'Akuntansi', 'jurusan' => 'Akuntansi',
                'jenjang' => 'S1', 'semester' => 5, 'tahun_akademik' => '2026/2027', 'status' => 'Cuti',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => false, 'alamat' => 'Jl. Perumnas No. 50', 'no_hp' => '08121111013'
            ],

            // Fakultas Hukum - Ilmu Hukum
            [
                'nim' => '230401001', 'nama' => 'Nadia Saphira', 'jenis_kelamin' => 'P',
                'fakultas' => 'Fakultas Hukum', 'program_studi' => 'Ilmu Hukum', 'jurusan' => 'Ilmu Hukum',
                'jenjang' => 'S1', 'semester' => 3, 'tahun_akademik' => '2026/2027', 'status' => 'Aktif',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => false, 'alamat' => 'Jl. Timoho No. 3', 'no_hp' => '08121111014'
            ],
            [
                'nim' => '220401015', 'nama' => 'Oki Setiawan', 'jenis_kelamin' => 'L',
                'fakultas' => 'Fakultas Hukum', 'program_studi' => 'Ilmu Hukum', 'jurusan' => 'Ilmu Hukum',
                'jenjang' => 'S1', 'semester' => 5, 'tahun_akademik' => '2026/2027', 'status' => 'Nonaktif',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => false, 'alamat' => 'Jl. Veteran No. 18', 'no_hp' => '08121111015'
            ],

            // Fakultas Pertanian - Agroteknologi
            [
                'nim' => '230501001', 'nama' => 'Putri Ayu Lestari', 'jenis_kelamin' => 'P',
                'fakultas' => 'Fakultas Pertanian', 'program_studi' => 'Agroteknologi', 'jurusan' => 'Agroteknologi',
                'jenjang' => 'S1', 'semester' => 3, 'tahun_akademik' => '2026/2027', 'status' => 'Aktif',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => true, 'alamat' => 'Jl. Tamansiswa No. 100', 'no_hp' => '08121111016'
            ],
            [
                'nim' => '210501008', 'nama' => 'Rian Hidayat', 'jenis_kelamin' => 'L',
                'fakultas' => 'Fakultas Pertanian', 'program_studi' => 'Agroteknologi', 'jurusan' => 'Agroteknologi',
                'jenjang' => 'S1', 'semester' => 7, 'tahun_akademik' => '2026/2027', 'status' => 'Aktif',
                'jenis_kelas' => 'Reguler', 'status_beasiswa' => false, 'alamat' => 'Jl. Parangtritis KM 4', 'no_hp' => '08121111017'
            ]
        ];

        foreach ($mahasiswas as $data) {
            $mhs = \App\Models\Mahasiswa::create($data);

            // Create initial status history records
            \App\Models\MahasiswaStatusHistory::create([
                'mahasiswa_id' => $mhs->id,
                'semester' => max(1, $mhs->semester - 2),
                'tahun_akademik' => '2025/2026',
                'status' => 'Aktif',
                'catatan' => 'Semester sebelumnya',
            ]);

            \App\Models\MahasiswaStatusHistory::create([
                'mahasiswa_id' => $mhs->id,
                'semester' => $mhs->semester,
                'tahun_akademik' => $mhs->tahun_akademik ?? '2026/2027',
                'status' => $mhs->status,
                'catatan' => 'Semester berjalan',
            ]);
        }
    }
}
