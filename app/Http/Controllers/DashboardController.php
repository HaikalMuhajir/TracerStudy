<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Performa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{


    public function getKesesuaianProfesi()
    {
        $prodi = session('filter.prodi');
        $tahunAwal = session('filter.tahun_awal');
        $tahunAkhir = session('filter.tahun_akhir');

        $query = Alumni::query();

        if ($prodi) {
            $query->where('prodi_id', $prodi);
        }
        if ($tahunAwal) {
            $query->whereYear('tanggal_lulus', '>=', $tahunAwal);
        }
        if ($tahunAkhir) {
            $query->whereYear('tanggal_lulus', '<=', $tahunAkhir);
        }

        $query->whereNotNull('tanggal_lulus');

        $alumni = $query->get();

        $grouped = $alumni->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->tanggal_lulus)->year;
        });

        $result = [];

        foreach ($grouped as $tahun => $items) {
            $terlacak = $items->filter(fn($item) => $item->kategori_profesi !== null);
            $infokom = $terlacak->filter(function ($item) {
                return strtolower($item->kategori_profesi) === 'infokom' && !empty($item->tanggal_pertama_kerja);
            })->count();

            $nonInfokom = $terlacak->filter(function ($item) {
                return strtolower($item->kategori_profesi) === 'non infokom' && !empty($item->tanggal_pertama_kerja);
            })->count();

            $internasional = $terlacak->where('skala_instansi', 'Internasional')->count();
            $nasional = $terlacak->where('skala_instansi', 'Nasional')->count();
            $wirausaha = $terlacak->where('skala_instansi', 'Wirausaha')->count();

            $result[] = [
                'tahun' => $tahun,
                'jumlah_lulusan' => $items->count(),
                'terlacak' => $terlacak->count(),
                'infokom' => $infokom,
                'non_infokom' => $nonInfokom,
                'internasional' => $internasional,
                'nasional' => $nasional,
                'wirausaha' => $wirausaha,
            ];
        }

        // Urutkan dari tahun terbesar ke terkecil
        usort($result, fn($a, $b) => $b['tahun'] <=> $a['tahun']);

        return $result;
    }

    public function getRataRataMasaTunggu()
    {
        $prodi = session('filter.prodi');
        $tahunAwal = session('filter.tahun_awal');
        $tahunAkhir = session('filter.tahun_akhir');

        $query = Alumni::query();

        if ($prodi) {
            $query->where('prodi_id', $prodi);
        }
        if ($tahunAwal) {
            $query->whereYear('tanggal_lulus', '>=', $tahunAwal);
        }
        if ($tahunAkhir) {
            $query->whereYear('tanggal_lulus', '<=', $tahunAkhir);
        }

        // Hanya data dengan tanggal lulus (tanpa memfilter tanggal kerja)
        $query->whereNotNull('tanggal_lulus');

        $alumni = $query->get();

        // Kelompokkan berdasarkan tahun lulus
        $grouped = $alumni->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_lulus)->year;
        });

        $result = [];

        foreach ($grouped as $tahun => $items) {
            $jumlah = 0;
            $totalBulan = 0;

            foreach ($items as $alumni) {
                // Lewati jika belum punya tanggal kerja
                if (empty($alumni->tanggal_pertama_kerja)) {
                    continue;
                }

                $lulus = Carbon::parse($alumni->tanggal_lulus);
                $kerja = Carbon::parse($alumni->tanggal_pertama_kerja);

                // Jika kerja sebelum lulus, masa tunggu = 0
                $masaTunggu = $kerja < $lulus ? 0 : $lulus->diffInDays($kerja) / 30.44;

                $totalBulan += $masaTunggu;
                $jumlah++;
            }

            $rataRata = $jumlah > 0 ? round($totalBulan / $jumlah, 1) : 0;

            $result[] = [
                'tahun' => $tahun,
                'jumlah_lulusan' => $items->count(),
                'terlacak' => $items->filter(function ($item) {
                    return !empty($item->kategori_profesi);
                })->count(),
                'rata_rata_bulan' => $rataRata,
            ];
        }

        usort($result, fn($a, $b) => $b['tahun'] <=> $a['tahun']);

        return $result;
    }



    public function index()
    {
        $dataKesesuaian = $this->getKesesuaianProfesi();
        $rataRataMasaTunggu = $this->getRataRataMasaTunggu();
        $prodi = session('filter.prodi');
        $tahunAwal = session('filter.tahun_awal');
        $tahunAkhir = session('filter.tahun_akhir');

        // Responden Line Chart
        $respondenQuery = Alumni::select(
            DB::raw('YEAR(tanggal_lulus) as tahun'),
            DB::raw('COUNT(*) as jumlah')
        )->whereNotNull('kategori_profesi');

        $this->applyBaseFilter($respondenQuery, $prodi, $tahunAwal, $tahunAkhir);

        $respondenData = $respondenQuery->groupBy(DB::raw('YEAR(tanggal_lulus)'))
            ->orderBy('tahun')
            ->get();

        $respondenLabels = $respondenData->pluck('tahun')->toArray();
        $respondenCounts = $respondenData->pluck('jumlah')->toArray();

        // Bar Chart Pekerjaan
        $pekerjaanQuery = Alumni::select('profesi', DB::raw('COUNT(*) as jumlah'))
            ->whereNotNull('profesi')
            ->groupBy('profesi')
            ->orderByDesc('jumlah')
            ->limit(10);

        $this->applyBaseFilter($pekerjaanQuery, $prodi, $tahunAwal, $tahunAkhir);

        $pekerjaanData = $pekerjaanQuery->groupBy('profesi')->orderByDesc('jumlah')->get();
        $pekerjaanLabels = $pekerjaanData->pluck('profesi')->toArray();
        $pekerjaanCounts = $pekerjaanData->pluck('jumlah')->toArray();

        // Pie Chart Jenis Instansi
        $defaultInstansiTypes = ['Swasta', 'Pemerintah', 'Pendidikan', 'Lainnya'];

        $instansiQuery = Alumni::select('jenis_instansi', DB::raw('COUNT(*) as jumlah'))
            ->whereNotNull('jenis_instansi');

        $this->applyBaseFilter($instansiQuery, $prodi, $tahunAwal, $tahunAkhir);

        $instansiRawData = $instansiQuery->groupBy('jenis_instansi')->get()->pluck('jumlah', 'jenis_instansi')->toArray();

        // Pastikan semua jenis instansi muncul meskipun tidak ada datanya
        $instansiLabels = [];
        $instansiCounts = [];

        foreach ($defaultInstansiTypes as $type) {
            $instansiLabels[] = $type;
            $instansiCounts[] = $instansiRawData[$type] ?? 0;
        }


        // Pie Chart Pelacakan
        $terlacakQuery = Alumni::select(
            DB::raw("CASE WHEN kategori_profesi IS NOT NULL THEN 'Terlacak' ELSE 'Tidak Terlacak' END AS status"),
            DB::raw('COUNT(*) as jumlah')
        );

        $this->applyBaseFilter($terlacakQuery, $prodi, $tahunAwal, $tahunAkhir);

        $defaultTerlacakLabels = ['Terlacak', 'Tidak Terlacak'];

        // Ambil data dari query
        $terlacakData = $terlacakQuery->groupBy('status')->get();

        // Buat array associative dari hasil query
        $terlacakRawData = $terlacakData->pluck('jumlah', 'status')->toArray();

        // Gabungkan dengan default, overwrite jika ada datanya
        foreach ($defaultTerlacakLabels as $label) {
            $terlacakCounts[] = $terlacakRawData[$label] ?? 0;
        }

        // Labelnya sama defaultnya
        $terlacakLabels = $defaultTerlacakLabels;

        // Radar Chart - Performa Alumni
        $aspekList = [
            'kerjasama_tim' => 'teamwork',
            'keahlian_ti' => 'expertise',
            'bahasa_asing' => 'language',
            'komunikasi' => 'communication',
            'pengembangan_diri' => 'development',
            'kepemimpinan' => 'leadership',
            'etos_kerja' => 'work_ethic',
        ];

        $performanceData = [];

        foreach ($aspekList as $dbField => $frontendKey) {
            $query = Performa::select($dbField, DB::raw('COUNT(*) as jumlah'))
                ->join('alumni', 'performa.alumni_id', '=', 'alumni.alumni_id')
                ->groupBy($dbField)
                ->orderBy($dbField);

            $this->applyBaseFilter($query, $prodi, $tahunAwal, $tahunAkhir, 'alumni');

            $counts = $query->pluck('jumlah', $dbField)->toArray();

            // Pastikan nilai dari 1-4 tetap ada meski nol
            $filledCounts = [];
            for ($i = 1; $i <= 4; $i++) {
                $filledCounts[] = $counts[$i] ?? 0;
            }

            $performanceData[$frontendKey] = $filledCounts;
        }


        return view('dashboard', [
            'rataRataMasaTunggu' => $rataRataMasaTunggu,
            'dataKesesuaian' => $dataKesesuaian,
            'respondenLabels' => $respondenLabels,
            'respondenCounts' => $respondenCounts,
            'pekerjaanLabels' => $pekerjaanLabels,
            'pekerjaanCounts' => $pekerjaanCounts,
            'instansiLabels' => $instansiLabels,
            'instansiCounts' => $instansiCounts,
            'terlacakLabels' => $terlacakLabels,
            'terlacakCounts' => $terlacakCounts,
            'performanceData' => $performanceData,
        ]);
    }

    /**
     * Terapkan filter berdasarkan prodi dan tahun
     */
    private function applyBaseFilter($query, $prodi, $tahunAwal, $tahunAkhir, $tableAlias = null)
    {
        $prefix = $tableAlias ? $tableAlias . '.' : '';

        if ($prodi) {
            $query->where($prefix . 'prodi_id', $prodi);
        }
        if ($tahunAwal) {
            $query->whereYear($prefix . 'tanggal_lulus', '>=', $tahunAwal);
        }
        if ($tahunAkhir) {
            $query->whereYear($prefix . 'tanggal_lulus', '<=', $tahunAkhir);
        }
    }
}
