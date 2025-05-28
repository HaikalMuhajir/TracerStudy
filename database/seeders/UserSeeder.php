<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan data pengguna secara manual
        DB::table('users')->insert([
            'name' => 'Septian',
            'email' => 'septiantito123@gmail.com',
            'password' => Hash::make('password123'), // Hash password sebelum disimpan
            'remember_token' => 1234, // Atau bisa dikosongkan jika tidak perlu
        ]);
    }
}
