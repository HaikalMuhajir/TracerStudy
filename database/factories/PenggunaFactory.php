<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PenggunaFactory extends Factory
{
    protected $model = \App\Models\Pengguna::class;

    public function definition()
    {
        return [
            'alumni_id' => \App\Models\Alumni::factory(),
            'nama' => $this->faker->name(),
            'jabatan' => $this->faker->jobTitle(),
            'no_hp' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
