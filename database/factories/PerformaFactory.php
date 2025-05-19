<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PerformaFactory extends Factory
{
    protected $model = \App\Models\Performa::class;

    public function definition()
    {
        return [
            'pengguna_id' => \App\Models\Pengguna::factory(),
            'alumni_id' => \App\Models\Alumni::factory(),

            'kerjasama_tim' => $this->faker->numberBetween(1,5),
            'keahlian_ti' => $this->faker->numberBetween(1,5),
            'bahasa_asing' => $this->faker->numberBetween(1,5),
            'komunikasi' => $this->faker->numberBetween(1,5),
            'pengembangan_diri' => $this->faker->numberBetween(1,5),
            'kepemimpinan' => $this->faker->numberBetween(1,5),
            'etos_kerja' => $this->faker->numberBetween(1,5),

            'kompetensi_kurang' => $this->faker->sentence(),
            'saran_kurikulum' => $this->faker->sentence(),
        ];
    }
}
