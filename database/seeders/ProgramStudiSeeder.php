<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('program_studi')->insert([
            ['nama_prodi' => 'D4 Sistem Informasi Bisnis'],
            ['nama_prodi' => 'D4 Teknik Informatika'],
            ['nama_prodi' => 'D2 PPLS'],
            ['nama_prodi' => 'S2 MRTI'],
        ]);
    }
}
