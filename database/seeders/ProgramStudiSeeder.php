<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('program_studi')->insert([
            ['nama_prodi' => 'Sistem Informasi Bisnis'],
            ['nama_prodi' => 'Teknik Informatika'],
        ]);
    }
}
