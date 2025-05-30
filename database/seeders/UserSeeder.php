<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
    [
        'name' => 'Admin 1',
        'email' => 'haikal.muhajir10@gmail.com',
        'password' => Hash::make('1231bismillah'),
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);

    }
}
