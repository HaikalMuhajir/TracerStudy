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

        // Buat 10 user dengan alumni, alumni otomatis akan buat program studi jika belum ada
        User::factory(10)->create()->each(function($user) {
            $alumni = Alumni::factory()->create([
                'user_id' => $user->user_id,
                'prodi_id' => ProgramStudi::inRandomOrder()->first()->prodi_id,
            ]);

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
