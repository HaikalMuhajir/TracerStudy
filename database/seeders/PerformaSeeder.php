<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerformaSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 10) as $i) {
            DB::table('performa')->insert([
                'pengguna_id' => $i,
                'alumni_id' => $i,
                'kerjasama_tim' => rand(1, 4),
                'keahlian_ti' => rand(1, 4),
                'bahasa_asing' => rand(1, 4),
                'komunikasi' => rand(1, 4),
                'pengembangan_diri' => rand(1, 4),
                'kepemimpinan' => rand(1, 4),
                'etos_kerja' => rand(1, 4),
                'kompetensi_kurang' => 'Kurang di bidang komunikasi.',
                'saran_kurikulum' => 'Perbanyak proyek kolaboratif dan magang.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
