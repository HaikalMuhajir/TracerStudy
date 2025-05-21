@extends('layouts.template')

@section('content')
    @php
        $currentYear = date('Y');
        $tahunAwalDefault = $currentYear - 3;
        $tahunAkhirDefault = $currentYear;
        $years = range(2021, $currentYear);
        $prodiList = ['D4 TI', 'D4 SIB', 'D2 PPLS', 'S2 MRTI'];
    @endphp

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @endpush

    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1 class="judul-halaman">Selamat Datang di Dashboard Admin</h1>
            <p class="subjudul-halaman">
                Menampilkan data untuk: <strong id="prodi-display">D4 TI</strong>, tahun 
                <strong id="tahun-display">{{ $tahunAwalDefault }} - {{ $tahunAkhirDefault }}</strong>
            </p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <h3>Filter Data</h3>
            <div class="filter-grid">
                <div>
                    <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                    <select id="prodi" class="w-full p-2 border border-blue-300 text-blue-700 bg-blue-50 rounded-md focus:ring-2 focus:ring-blue-500">
                        @foreach ($prodiList as $item)
                            <option value="{{ $item }}" {{ $item === 'D4 TI' ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tahun_awal" class="block text-sm font-medium text-gray-700 mb-1">Tahun Awal</label>
                    <select id="tahun_awal" class="w-full p-2 border border-blue-300 text-blue-700 bg-blue-50 rounded-md focus:ring-2 focus:ring-blue-500">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $year === $tahunAwalDefault ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tahun_akhir" class="block text-sm font-medium text-gray-700 mb-1">Tahun Akhir</label>
                    <select id="tahun_akhir" class="w-full p-2 border border-blue-300 text-blue-700 bg-blue-50 rounded-md focus:ring-2 focus:ring-blue-500">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $year === $tahunAkhirDefault ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-3 text-right">
                    <button id="apply-filter" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-md hover:from-blue-700 hover:to-blue-900 transition-all duration-300">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-grid">
            <div class="chart-container">
                <canvas id="sebaranProfesiChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="sebaranInstansiChart"></canvas>
            </div>
<div class="chart-container flex flex-col pt-0">
    <div class="filter-section w-full md:w-1/4 mb-0 pb-0 ">
        <label for="kepuasan-criteria" class="block text-sm font-medium text-gray-700 text-center py-0 my-0 mt-1">
            Kriteria Kepuasan
        </label>
        <select id="kepuasan-criteria" class="w-full p-2 border border-blue-300 text-blue-700 bg-blue-50 rounded-md focus:ring-2 focus:ring-blue-500 my-0 py-0">
            <option value="kepuasanPenggunaLulusan1">Kerjasama Tim</option>
            <option value="kepuasanPenggunaLulusan2">Keahlian di Bidang TI</option>
            <option value="kepuasanPenggunaLulusan3">Kemampuan Berbahasa Asing (Inggris)</option>
            <option value="kepuasanPenggunaLulusan4">Kemampuan Berkomunikasi</option>
            <option value="kepuasanPenggunaLulusan5">Pengembangan Diri</option>
            <option value="kepuasanPenggunaLulusan6">Kepemimpinan</option>
            <option value="kepuasanPenggunaLulusan7">Etos Kerja</option>
        </select>
    </div>
    <canvas id="kepuasanPenggunaChart" class="w-full md:w-3/4 pt-0 mt-0"></canvas>

</div>

        </div>

        <!-- Table: Sebaran Tempat Kerja & Kesesuaian Profesi -->
        <div class="table-section">
            <h3 class="text-white text-center">Sebaran Tempat Kerja & Kesesuaian Profesi</h3>
            <div class="table-responsive">
                <table id="data-table" class="w-full">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center">Tahun Lulus</th>
                            <th rowspan="2" class="text-center">Jumlah Lulusan</th>
                            <th rowspan="2" class="text-center">Terlacak</th>
                            <th colspan="2" class="text-center">Kesesuaian Profesi</th>
                            <th colspan="3" class="text-center">Jenis Tempat Kerja</th>
                        </tr>
                        <tr>
                            <th class="text-center">Infokom</th>
                            <th class="text-center">Non Infokom</th>
                            <th class="text-center">Multinasional</th>
                            <th class="text-center">Nasional</th>
                            <th class="text-center">Wirausaha</th>
                        </tr>
                    </thead>
                    <tbody id="table-body"></tbody>
                    <tfoot id="table-footer"></tfoot>
                </table>
            </div>
        </div>

        <!-- Table: Rata-Rata Masa Tunggu -->
        <div class="table-section">
            <h3 class="text-white text-center">Rata-Rata Masa Tunggu</h3>
            <div class="table-responsive">
                <table id="data-table" class="w-full">
                    <thead>
                        <tr>
                            <th class="text-center">Tahun Lulus</th>
                            <th class="text-center">Jumlah Lulusan</th>
                            <th class="text-center">Jumlah Lulusan yang Terlacak</th>
                            <th class="text-center">Rata-rata Waktu Tunggu (Bulan)</th>
                        </tr>
                    </thead>
                    <tbody id="body-masa-tunggu"></tbody>
                    <tfoot id="footer-masa-tunggu"></tfoot>
                </table>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
        <script src="{{ asset('js/dashboard.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                initializeCharts(dataByProdi['D4 TI']);
                updateTable(dataByProdi['D4 TI'], {{ $tahunAwalDefault }}, {{ $tahunAkhirDefault }});
                updateTableMasaTunggu(dataByProdi['D4 TI'], {{ $tahunAwalDefault }}, {{ $tahunAkhirDefault }});
            });
        </script>
    </div>
@endsection
