<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Performa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function showForm($token)
    {
        $pengguna = Pengguna::where('token', $token)->first();
        if (!$pengguna) {
            return view('token-invalid');
        }

        // Ambil tahun kerja dari alumni yang terkait dengan performa
        $tahunKerjaList = Performa::where('pengguna_id', $pengguna->pengguna_id)
            ->with('alumni')
            ->get()
            ->pluck('alumni.tanggal_pertama_kerja')
            ->filter()
            ->map(fn($tanggal) => Carbon::parse($tanggal)->format('Y'))
            ->unique()
            ->sortDesc()
            ->values()
            ->all();

        // Tangkap tahun dari query string
        $selectedYear = request()->query('tahun');

        $performaIsi = null;
        $performaTerisi = false;

        if ($selectedYear) {
            $performaIsi = Performa::where('pengguna_id', $pengguna->pengguna_id)
                ->whereHas('alumni', fn($q) => $q->whereYear('tanggal_pertama_kerja', $selectedYear))
                ->first();

            // Cek apakah ada nilai di salah satu aspek performa
            if ($performaIsi) {
                $performaTerisi = collect([
                    $performaIsi->kerjasama_tim,
                    $performaIsi->keahlian_ti,
                    $performaIsi->bahasa_asing,
                    $performaIsi->komunikasi,
                    $performaIsi->pengembangan_diri,
                    $performaIsi->kepemimpinan,
                    $performaIsi->etos_kerja,
                ])->filter(fn($value) => !is_null($value))->isNotEmpty();
            }
        }

        return view('pengguna.form', compact('pengguna', 'tahunKerjaList', 'selectedYear', 'performaIsi', 'performaTerisi'));
    }

    public function submitForm(Request $request, $token)
    {
        $pengguna = \App\Models\Pengguna::where('token', $token)->first();
        if (!$pengguna) {
            return view('token-invalid');
        }

        $tahunKerjaList = \App\Models\Performa::where('pengguna_id', $pengguna->pengguna_id)
            ->with('alumni')
            ->get()
            ->pluck('alumni.tanggal_pertama_kerja')
            ->filter()
            ->map(function ($tanggal) {
                return \Carbon\Carbon::parse($tanggal)->format('Y');
            })
            ->unique()
            ->sortDesc()
            ->values()
            ->all();

        // Tambahkan validasi tahun_kerja
        $validated = $request->validate([
            'tahun_kerja' => ['required', 'digits:4', 'integer', \Illuminate\Validation\Rule::in($tahunKerjaList)],
            'kerjasama_tim' => 'required|integer',
            'keahlian_ti' => 'required|integer',
            'bahasa_asing' => 'required|integer',
            'komunikasi' => 'required|integer',
            'pengembangan_diri' => 'required|integer',
            'kepemimpinan' => 'required|integer',
            'etos_kerja' => 'required|integer',
            'kompetensi_kurang' => 'nullable|string',
            'saran_kurikulum' => 'nullable|string',
        ]);

        $tahun = $validated['tahun_kerja'];

        \App\Models\Performa::where('pengguna_id', $pengguna->pengguna_id)
            ->whereHas('alumni', function ($q) use ($tahun) {
                $q->whereYear('tanggal_pertama_kerja', $tahun);
            })
            ->get()
            ->each(function ($performa) use ($validated) {
                $performa->update([
                    'kerjasama_tim' => $validated['kerjasama_tim'],
                    'keahlian_ti' => $validated['keahlian_ti'],
                    'bahasa_asing' => $validated['bahasa_asing'],
                    'komunikasi' => $validated['komunikasi'],
                    'pengembangan_diri' => $validated['pengembangan_diri'],
                    'kepemimpinan' => $validated['kepemimpinan'],
                    'etos_kerja' => $validated['etos_kerja'],
                    'kompetensi_kurang' => $validated['kompetensi_kurang'],
                    'saran_kurikulum' => $validated['saran_kurikulum'],
                ]);
            });

        return redirect()->back()->with('success', "Performa alumni tahun $tahun berhasil diperbarui.");
    }
}
