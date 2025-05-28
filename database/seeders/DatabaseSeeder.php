<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramStudi;
use App\Models\User;
use App\Models\Alumni;
use App\Models\Performa;
use App\Models\Pengguna;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Buat 5 program studi
        ProgramStudi::factory(5)->create();

        // Buat 10 user tanpa relasi ke alumni
        User::factory(10)->create();

        // Buat 10 alumni, tanpa kaitkan ke user
        Alumni::factory(10)->create([
            'prodi_id' => ProgramStudi::inRandomOrder()->first()->prodi_id,
        ])->each(function ($alumni) {
            // Buat 1 pengguna untuk alumni tsb
            $pengguna = Pengguna::factory()->create([
                'alumni_id' => $alumni->alumni_id,
            ]);

            // Buat 2 performa untuk pengguna tsb dan alumni tsb
            Performa::factory(2)->create([
                'pengguna_id' => $pengguna->pengguna_id,
                'alumni_id' => $alumni->alumni_id,
            ]);
        });
    }
}
