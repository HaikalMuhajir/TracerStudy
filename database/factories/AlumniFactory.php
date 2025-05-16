<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlumniFactory extends Factory
{
    protected $model = \App\Models\Alumni::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'prodi_id' => \App\Models\ProgramStudi::factory(),
            'nim' => $this->faker->unique()->numerify('2023######'),
            'no_hp' => $this->faker->phoneNumber(),
            'jenis_instansi' => $this->faker->word(),
            'nama_instansi' => $this->faker->company(),
            'skala_instansi' => $this->faker->randomElement(['Nasional', 'Multinasional', 'Wirausaha']),
            'lokasi_instansi' => $this->faker->city(),
            'kategori_profesi' => $this->faker->jobTitle(),
            'profesi' => $this->faker->jobTitle(),
            'tanggal_lulus' => $this->faker->date(),
            'tahun_lulus' => $this->faker->year(),
            'tanggal_pertama_kerja' => $this->faker->date(),
        ];
    }
}
