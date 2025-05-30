<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $jenisInstansi = ['BUMN', 'Pendidikan Tinggi', 'Lainnya', 'Pemerintah', 'Swasta'];
        $kategoriProfesi = [
            'Bidang Infokom', 'Bidang Non Infokom', 'Belum Bekerja'
        ];
        $profesiInfokom = [
            'Developer/Programmer/Software Engineer',
            'IT Support/IT Administrator',
            'Infrastructure Engineer',
            'Digital Marketing Specialist',
            'Graphic Designer/Multimedia Designer',
            'Business Analyst',
            'QA Engineer/Tester',
            'IT Enterpreneur',
            'Trainer/Guru/Dosen (IT)',
            'Mahasiswa',
            'Lainnya: .....'
        ];
        $profesiNonInfokom = [
            'Procurement & Operational Team',
            'Wirausahawan (Non IT)',
            'Trainer/Guru/Dosen (Non IT)',
            'Mahasiswa',
            'Lainnya: ......'
        ];
        $skalaInstansi = ['Nasional', 'Internasional', 'Wirausaha'];

        foreach (range(1, 10) as $i) {
            $kategori = $kategoriProfesi[array_rand($kategoriProfesi)];
            $isInfokom = $kategori === 'Bidang Infokom' ? 1 : ($kategori === 'Bidang Non Infokom' ? 0 : null);
            $profesi = $kategori === 'Bidang Infokom'
                ? $profesiInfokom[array_rand($profesiInfokom)]
                : ($kategori === 'Bidang Non Infokom'
                    ? $profesiNonInfokom[array_rand($profesiNonInfokom)]
                    : null);

            DB::table('alumni')->insert([
                'prodi_id' => rand(1, 2),
                'nama' => 'Alumni ' . $i,
                'nim' => '20' . rand(15, 25) . '001' . $i,
                'no_hp' => '08' . rand(1111111111, 9999999999),
                'email' => 'alumni' . $i . '@mail.com',
                'jenis_instansi' => $jenisInstansi[array_rand($jenisInstansi)],
                'nama_instansi' => 'Instansi ' . $i,
                'skala_instansi' => $skalaInstansi[array_rand($skalaInstansi)],
                'lokasi_instansi' => 'Kota ' . $i,
                'kategori_profesi' => $kategori,
                'profesi' => $profesi,
                // 'is_infokom' => $isInfokom,
                'tanggal_lulus' => now()->subYears(rand(0, 10))->format('Y-m-d'),
                'tanggal_pertama_kerja' => now()->subYears(rand(0, 9))->format('Y-m-d'),
                'token' => Str::random(64),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
