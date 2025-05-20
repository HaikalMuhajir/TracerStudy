@extends('layouts.template')

@section('content')
    @php
        $currentYear = date('Y');
        $tahunAwalDefault = $currentYear - 3;
        $tahunAkhirDefault = $currentYear;
    @endphp

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @endpush

    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1 class="judul-halaman">Selamat Datang di Dashboard Admin</h1>
            <p class="subjudul-halaman">
                Menampilkan data untuk: <strong id="prodi-display">D4 TI</strong>, tahun <strong
                    id="tahun-display">{{ $tahunAwalDefault }} - {{ $tahunAkhirDefault }}</strong><br>
            </p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <h3>Filter Data</h3>
            <div class="filter-grid">
                <div>
                    <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                    <select id="prodi"
                        class="w-full p-2 border border-blue-300 text-blue-700 bg-blue-50 rounded-md focus:ring-2 focus:ring-blue-500">
                        @foreach (['D4 TI', 'D4 SIB', 'D2 PPLS', 'S2 MRTI'] as $item)
                            <option value="{{ $item }}" {{ 'D4 TI' == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tahun_awal" class="block text-sm font-medium text-gray-700 mb-1">Tahun Awal</label>
                    <select id="tahun_awal"
                        class="w-full p-2 border border-blue-300 text-blue-700 bg-blue-50 rounded-md focus:ring-2 focus:ring-blue-500">
                        @for ($i = 2021; $i <= $currentYear; $i++)
                            <option value="{{ $i }}" {{ $tahunAwalDefault == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="tahun_akhir" class="block text-sm font-medium text-gray-700 mb-1">Tahun Akhir</label>
                    <select id="tahun_akhir"
                        class="w-full p-2 border border-blue-300 text-blue-700 bg-blue-50 rounded-md focus:ring-2 focus:ring-blue-500">
                        @for ($i = 2021; $i <= $currentYear; $i++)
                            <option value="{{ $i }}" {{ $tahunAkhirDefault == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="md:col-span-3 text-right">
                    <button id="apply-filter"
                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-md hover:from-blue-700 hover:to-blue-900 transition-all duration-300">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-grid">
            <div class="chart-container">
                <canvas id="sebaranProfesiChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="sebaranInstansiChart"></canvas>
            </div>
        </div>

        <!-- Table -->
        <div class="table-section">
            <h3>Sebaran Tempat Kerja & Kesesuaian Profesi</h3>
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
                    <tfoot id="table-footer">
                        <!-- Total row will be inserted here by JavaScript -->
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Table Rata-Rata Masa Tunggu -->
        <div class="table-section">
            <h3>Tabel Rata-Rata Masa Tunggu</h3>
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
                    <tfoot id="footer-masa-tunggu">
                        <!-- Total row will be inserted here by JavaScript -->
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Chart Kepuasan Pengguna Lulusan -->
        <h3>Grafik Kepuasan Pengguna Lulusan</h3>
        <div class="charts-grid">
            <div class="chart-container">
                <canvas id="kepuasanPenggunaLulusan1"></canvas> <!-- Kerjasama Tim -->
            </div>
            <div class="chart-container">
                <canvas id="kepuasanPenggunaLulusan2"></canvas> <!-- Keahlian bidang TI -->
            </div>
            <div class="chart-container">
                <canvas id="kepuasanPenggunaLulusan3"></canvas> <!-- Kemampuan bahasa Asing (Inggris) -->
            </div>
            <div class="chart-container">
                <canvas id="kepuasanPenggunaLulusan4"></canvas> <!-- Kemampuan Berkomunikasi -->
            </div>
            <div class="chart-container">
                <canvas id="kepuasanPenggunaLulusan5"></canvas> <!-- Pengembangan Diri -->
            </div>
            <div class="chart-container">
                <canvas id="kepuasanPenggunaLulusan6"></canvas> <!-- Kepemimpinan -->
            </div>
            <div class="chart-container">
                <canvas id="kepuasanPenggunaLulusan7"></canvas> <!-- Etos Kerja -->
            </div>
        </div>

        <!-- Include Chart.js and dashboard.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('js/dashboard.js') }}"></script>
        <script>
            // Initial Load
            initializeCharts(dataByProdi['D4 TI']);
            updateTable(dataByProdi['D4 TI'], {{ $tahunAwalDefault }}, {{ $tahunAkhirDefault }});
            updateTableMasaTunggu(dataByProdi['D4 TI'], {{ $tahunAwalDefault }}, {{ $tahunAkhirDefault }});
        </script>
    </div>
@endsection