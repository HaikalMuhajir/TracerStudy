<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PerformaSeeder extends Seeder
{
    public function run(): void
    {
        $jenisInstansiList = ['Swasta', 'Pendidikan', 'Pemerintah', 'Lainnya'];
        $skalaInstansiList = ['Internasional', 'Nasional', 'Wirausaha'];
        $kategoriProfesiList = ['Infokom', 'Non Infokom', 'Tidak bekerja'];
        $profesiList = [
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
            'Lainnya: ..... ',
            'Procurement & Operational Team',
            'Wirausahawan (Non IT)',
            'Trainer/Guru/Dosen (Non IT)',
            'Mahasiswa',
        ];

        $firstNames = ['Andi', 'Rina', 'Dewi', 'Budi', 'Sari', 'Agus', 'Lina', 'Rudi', 'Tina', 'Eka', 'Dina', 'Rian', 'Indah', 'Hadi', 'Tari'];
        $lastNames = ['Saputra', 'Susanti', 'Wijaya', 'Pratama', 'Kusuma', 'Putri', 'Santoso', 'Permadi', 'Nugroho', 'Siregar'];

        for ($i = 1; $i <= 173; $i++) {
            $prodiId = rand(1, 4);
            $jenisInstansi = $jenisInstansiList[array_rand($jenisInstansiList)];
            $skalaInstansi = $skalaInstansiList[array_rand($skalaInstansiList)];
            $kategoriProfesi = $kategoriProfesiList[array_rand($kategoriProfesiList)];
            $profesi = $kategoriProfesi === 'Tidak bekerja'
                ? null
                : $profesiList[array_rand($profesiList)];

            $tahunLulus = rand(2019, 2023);
            $tanggalLulus = Carbon::create($tahunLulus, rand(1, 12), rand(1, 28));
            $tanggalKerja = (clone $tanggalLulus)->addMonths(rand(1, 12));

            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;

            $butuhPerforma = $skalaInstansi !== 'Wirausaha' && $kategoriProfesi !== 'Tidak bekerja';

            // Insert alumni
            $alumniId = DB::table('alumni')->insertGetId([
                'prodi_id' => $prodiId,
                'nama' => $fullName,
                'nim' => 'A' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'no_hp' => '08' . rand(1000000000, 9999999999),
                'email' => strtolower($firstName . $lastName . $i) . '@mail.com',
                'jenis_instansi' => $jenisInstansi,
                'nama_instansi' => 'PT ' . ucfirst(Str::random(6)),
                'skala_instansi' => $skalaInstansi,
                'lokasi_instansi' => 'Kota ' . chr(65 + ($i % 26)),
                'kategori_profesi' => $kategoriProfesi,
                'profesi' => $profesi,
                'token' => Str::random(64),
                'tanggal_lulus' => $tanggalLulus,
                'tanggal_pertama_kerja' => $tanggalKerja,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($butuhPerforma) {
                $atasanFirst = $firstNames[array_rand($firstNames)];
                $atasanLast = $lastNames[array_rand($lastNames)];
                $atasanName = $atasanFirst . ' ' . $atasanLast;

                $penggunaId = DB::table('pengguna')->insertGetId([
                    'nama' => $atasanName,
                    'jabatan' => 'Manajer HRD',
                    'no_hp' => '08' . rand(1000000000, 9999999999),
                    'email' => strtolower($atasanFirst . $atasanLast . $i) . '@company.com',
                    'token' => Str::random(64),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('performa')->insert([
                    'pengguna_id' => $penggunaId,
                    'alumni_id' => $alumniId,
                    'kerjasama_tim' => rand(1, 4),
                    'keahlian_ti' => rand(1, 4),
                    'bahasa_asing' => rand(1, 4),
                    'komunikasi' => rand(1, 4),
                    'pengembangan_diri' => rand(1, 4),
                    'kepemimpinan' => rand(1, 4),
                    'etos_kerja' => rand(1, 4),
                    'kompetensi_kurang' => 'Kurang pengalaman lapangan.',
                    'saran_kurikulum' => 'Perlu peningkatan pelatihan soft skill dan praktik langsung.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
