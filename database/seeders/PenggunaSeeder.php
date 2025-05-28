<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 10) as $i) {
            DB::table('pengguna')->insert([
                'alumni_id' => $i,
                'nama' => 'Pengguna ' . $i,
                'jabatan' => 'Manager',
                'no_hp' => '08' . rand(1111111111, 9999999999),
                'email' => 'pengguna' . $i . '@mail.com',
                'token' => Str::random(64),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
