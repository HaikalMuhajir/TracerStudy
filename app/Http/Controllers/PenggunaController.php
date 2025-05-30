<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function showForm($token)
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
        ->map(function($tanggal) {
            return \Carbon\Carbon::parse($tanggal)->format('Y');
        })
        ->unique()
        ->sortDesc()
        ->values()
        ->all();

    return view('pengguna.form', compact('pengguna', 'tahunKerjaList'));
}


    public function submitForm(Request $request, $token)
{
    $pengguna = \App\Models\Pengguna::where('token', $token)->first();
    if (!$pengguna) {
        return view('token-invalid');
    }

    // Tambahkan validasi tahun_kerja
    $validated = $request->validate([
        'tahun_kerja' => 'required|digits:4|integer',
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
