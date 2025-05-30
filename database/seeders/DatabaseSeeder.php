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
    public function run(): void
    {
        $this->call([
            ProgramStudiSeeder::class,
            UserSeeder::class,
            PerformaSeeder::class
        ]);
    }
}
