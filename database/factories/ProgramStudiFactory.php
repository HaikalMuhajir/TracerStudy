<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramStudiFactory extends Factory
{
    protected $model = \App\Models\ProgramStudi::class;

    public function definition()
    {
        return [
            'nama_prodi' => $this->faker->unique()->word(),
        ];
    }
}
