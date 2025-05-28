<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Performa;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Menampilkan semua data alumni (dengan filter opsional)
    public function index(Request $request)
    {
        return view('laporan.index');
    }

    // Menampilkan form tambah alumni
    public function create()
    {
        return view('alumni.create');
    }

}
