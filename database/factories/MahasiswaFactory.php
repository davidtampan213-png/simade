<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $angkatan = $this->faker->randomElement(['2021', '2022', '2023', '2024']);
        $jurusan = $this->faker->randomElement(['Teknik Informatika', 'Teknik Mesin', 'Manajemen Informatika', 'Arsitek', 'Teknik Sipil']);
        
        return [
            'nim' => $angkatan . $this->faker->unique()->numerify('######'),
            'nama' => $this->faker->name(),
            'jurusan' => $jurusan,
            'status' => $this->faker->randomElement(['Aktif', 'Aktif', 'Aktif', 'Aktif', 'Nonaktif']),
            'jenis_kelas' => $this->faker->randomElement(['Reguler', 'Reguler', 'Ekstensi']),
            'status_beasiswa' => $this->faker->boolean(15),
            'alamat' => $this->faker->address(),
            'no_hp' => $this->faker->phoneNumber(),
        ];
    }
}
