<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function set(Request $request)
    {
        session([
            'filter.prodi' => $request->input('prodi'),
            'filter.tahun_awal' => $request->input('tahun_awal'),
            'filter.tahun_akhir' => $request->input('tahun_akhir'),
        ]);

        return redirect()->back();
    }

    public function reset()
    {
        session()->forget(['filter.prodi', 'filter.tahun_awal', 'filter.tahun_akhir']);

        return redirect()->back();
    }
}
