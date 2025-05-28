<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Performa;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil nilai filter dari session
        $prodi = session('filter.prodi');
        $tahunAwal = session('filter.tahun_awal');
        $tahunAkhir = session('filter.tahun_akhir');

        // Filter dasar
        $baseFilter = function ($query) use ($prodi, $tahunAwal, $tahunAkhir) {
            if ($prodi) {
                $query->where('prodi', $prodi);
            }
            if ($tahunAwal) {
                $query->whereYear('tanggal_lulus', '>=', $tahunAwal);
            }
            if ($tahunAkhir) {
                $query->whereYear('tanggal_lulus', '<=', $tahunAkhir);
            }
        };

        // Data untuk Line Chart Responden
        $respondenQuery = Alumni::select(
            DB::raw('YEAR(tanggal_lulus) as tahun'),
            DB::raw('COUNT(*) as jumlah')
        )->whereNotNull('profesi');

        $baseFilter($respondenQuery);

        $respondenData = $respondenQuery->groupBy(DB::raw('YEAR(tanggal_lulus)'))
            ->orderBy('tahun')
            ->get();

        $respondenLabels = $respondenData->pluck('tahun')->toArray();
        $respondenCounts = $respondenData->pluck('jumlah')->toArray();

        // Data untuk Bar Chart Pekerjaan
        $pekerjaanQuery = Alumni::select('profesi', DB::raw('COUNT(*) as jumlah'))
            ->whereNotNull('profesi');

        $baseFilter($pekerjaanQuery);

        $pekerjaanData = $pekerjaanQuery->groupBy('profesi')->orderByDesc('jumlah')->get();
        $pekerjaanLabels = $pekerjaanData->pluck('profesi')->toArray();
        $pekerjaanCounts = $pekerjaanData->pluck('jumlah')->toArray();

        // Data untuk Pie Chart Jenis Instansi
        $instansiQuery = Alumni::select('jenis_instansi', DB::raw('COUNT(*) as jumlah'))
            ->whereNotNull('jenis_instansi');

        $baseFilter($instansiQuery);

        $instansiData = $instansiQuery->groupBy('jenis_instansi')->get();

        $instansiLabels = $instansiData->pluck('jenis_instansi')->toArray();
        $instansiCounts = $instansiData->pluck('jumlah')->toArray();

        // Data untuk Pie Chart Pelacakan
        $terlacakQuery = Alumni::select(
            DB::raw("CASE WHEN profesi IS NOT NULL THEN 'Terlacak' ELSE 'Tidak Terlacak' END AS status"),
            DB::raw('COUNT(*) as jumlah')
        );

        $baseFilter($terlacakQuery);

        $terlacakData = $terlacakQuery->groupBy('status')->get();
        $terlacakLabels = $terlacakData->pluck('status')->toArray();
        $terlacakCounts = $terlacakData->pluck('jumlah')->toArray();


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

        // Filter dinamis dari alumni
        if ($prodi) {
            $query->where('alumni.prodi', $prodi);
        }

        if ($tahunAwal) {
            $query->whereYear('alumni.tanggal_lulus', '>=', $tahunAwal);
        }

        if ($tahunAkhir) {
            $query->whereYear('alumni.tanggal_lulus', '<=', $tahunAkhir);
        }

        $counts = $query->pluck('jumlah', $dbField)->toArray();

        // Pastikan array lengkap dari 1 sampai 4, kalau tidak ada data kasih 0
        $filledCounts = [];
        for ($i = 1; $i <= 4; $i++) {
            $filledCounts[] = $counts[$i] ?? 0;
        }

        $performanceData[$frontendKey] = $filledCounts;
    }

        return view('dashboard', [
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
}
