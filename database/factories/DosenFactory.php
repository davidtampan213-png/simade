<?php

namespace Database\Factories;

use App\Models\Dosen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dosen>
 */
class DosenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jurusan = $this->faker->randomElement(['Teknik Informatika', 'Teknik Mesin', 'Manajemen Informatika', 'Arsitek', 'Teknik Sipil']);
        
        return [
            'nip' => $this->faker->unique()->numerify('19##########'),
            'nama' => $this->faker->name(),
            'jurusan' => $jurusan,
            'status' => $this->faker->randomElement(['Aktif', 'Aktif', 'Aktif', 'Nonaktif']),
            'no_hp' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
        ];
    }
}
