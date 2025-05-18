@extends('layouts.template')

@section('content')
@php
    $currentYear = date('Y');
    $tahunAwalDefault = $currentYear - 3;
    $tahunAkhirDefault = $currentYear;
@endphp

<style>
    .dashboard-container {
        background: linear-gradient(135deg, #f0f4f8, #e0e7ff);
        min-height: 100vh;
        padding: 40px 60px;
        font-family: 'Poppins', sans-serif;
    }
    .filter-section {
        background: rgba(255, 255, 255, 0.9);
        padding: 25px;
        border-radius: 15px;
        border: 1px solid #e0e7ff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(5px);
        margin-bottom: 40px;
        transition: transform 0.3s ease;
    }
    .filter-section:hover {
        transform: translateY(-5px);
    }
    .filter-section h3 {
        font-size: 1.75rem;
        color: #1e3a8a;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .filter-section .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    .filter-section label {
        font-size: 0.95rem;
        color: #374151;
        margin-bottom: 5px;
        display: block;
    }
    .filter-section select {
        width: 100%;
        padding: 10px;
        border: 1px solid #93c5fd;
        border-radius: 8px;
        background: #f0f9ff;
        color: #1e40af;
        font-weight: 500;
        transition: border-color 0.3s ease;
    }
    .filter-section select:focus {
        border-color: #3b82f6;
        outline: none;
    }
    .filter-section button {
        padding: 12px 24px;
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease;
    }
    .filter-section button:hover {
        background: linear-gradient(90deg, #2563eb, #3b82f6);
        transform: translateY(-2px);
    }
    .welcome-section {
        text-align: center;
        margin-bottom: 50px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }
    .judul-halaman {
        font-size: 2.8rem;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .subjudul-halaman {
        font-size: 1.25rem;
        color: #64748b;
        font-weight: 500;
    }
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }
    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 20px;
        width: 100%;
        height: 320px; /* Reduced height for smaller pie charts */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    .chart-container:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }
    canvas {
        width: 100% !important;
        height: 100% !important;
    }
    
    /* Improved Table Styles */
    .table-section {
        margin-top: 50px;
    }
    .table-section h3 {
        font-size: 1.75rem;
        color: #1e3a8a;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .table-responsive {
        overflow-x: auto;
        background: white;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }
    
    #data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }
    
    #data-table th, #data-table td {
        padding: 10px 12px;
        text-align: center;
        border-bottom: 1px solid #e0e7ff;
    }
    
    #data-table th {
        background: #f8fafc;
        color: #1e3a8a;
        font-weight: 600;
        position: sticky;
        top: 0;
    }
    
    #data-table thead tr:first-child th {
        background: #e0e7ff;
        border-bottom: 2px solid #93c5fd;
    }
    
    #data-table tbody tr:hover {
        background-color: #f0f9ff;
    }
    
    #data-table tfoot tr {
        background: linear-gradient(90deg, #f0f4f8, #e0e7ff);
        border-top: 2px solid #93c5fd;
        font-weight: 600;
    }
    
    /* Zebra striping for better readability */
    #data-table tbody tr:nth-child(even) {
        background-color: #f8fafc;
    }
    
    #data-table tbody tr:nth-child(even):hover {
        background-color: #f0f9ff;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 20px;
        }
        .judul-halaman {
            font-size: 2rem;
        }
        .charts-grid {
            grid-template-columns: 1fr;
        }
        .chart-container {
            height: 280px;
        }
        #data-table th, #data-table td {
            padding: 8px 10px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1 class="judul-halaman">Selamat Datang di Dashboard Admin</h1>
        <p class="subjudul-halaman">
            Menampilkan data untuk: <strong id="prodi-display">D4 TI</strong>, tahun <strong id="tahun-display">{{ $tahunAwalDefault }} - {{ $tahunAkhirDefault }}</strong><br>
        </p>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <h3>Filter Data</h3>
        <div class="filter-grid">
            <div>
                <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                <select id="prodi" class="w-full p-2 border border-blue-300 text-blue-700 bg-blue-50 rounded-md focus:ring-2 focus:ring-blue-500">
                    @foreach (['D4 TI', 'D4 SIB', 'D2 PPLS', 'S2 MRTI'] as $item)
                        <option value="{{ $item }}" {{ 'D4 TI' == $item ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tahun_awal" class="block text-sm font-medium text-gray-700 mb-1">Tahun Awal</label>
                <select id="tahun_awal" class="w-full p-2 border border-blue-300 text-blue-700 bg-blue-50 rounded-md focus:ring-2 focus:ring-blue-500">
                    @for ($i = 2021; $i <= $currentYear; $i++)
                        <option value="{{ $i }}" {{ $tahunAwalDefault == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="tahun_akhir" class="block text-sm font-medium text-gray-700 mb-1">Tahun Akhir</label>
                <select id="tahun_akhir" class="w-full p-2 border border-blue-300 text-blue-700 bg-blue-50 rounded-md focus:ring-2 focus:ring-blue-500">
                    @for ($i = 2021; $i <= $currentYear; $i++)
                        <option value="{{ $i }}" {{ $tahunAkhirDefault == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="md:col-span-3 text-right">
                <button id="apply-filter" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-md hover:from-blue-700 hover:to-blue-900 transition-all duration-300">
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
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data for different Program Studi
    const dataByProdi = {
        'D4 TI': {
            profesi: { 'Lainnya': 25.5, 'Data Analyst': 6.4, 'Customer Service': 5.1, 'Product QA': 3.8, 'Teknisi': 1.3, 'Perekayasa PL': 31.8, 'Start IT': 10.8, 'Marketing': 5.1, 'Usaha': 10.2 },
            instansi: { 'Pendidikan Tinggi': 10, 'Instansi Pemerintah': 30, 'Perusahaan Swasta': 50, 'BUMN': 10 },
            table: [
                { tahun: 2021, jumlahLulusan: 213, terlacak: 64, infokom: 46, nonInfokom: 18, multi: 0, nasional: 63, wirausaha: 1 },
                { tahun: 2022, jumlahLulusan: 188, terlacak: 115, infokom: 73, nonInfokom: 42, multi: 4, nasional: 108, wirausaha: 3 },
                { tahun: 2023, jumlahLulusan: 233, terlacak: 98, infokom: 70, nonInfokom: 28, multi: 2, nasional: 90, wirausaha: 6 },
                { tahun: 2024, jumlahLulusan: 200, terlacak: 112, infokom: 82, nonInfokom: 30, multi: 3, nasional: 107, wirausaha: 2 }
            ]
        },
        'D4 SIB': {
            profesi: { 'Lainnya': 20, 'Data Analyst': 10, 'Customer Service': 5, 'Product QA': 5, 'Teknisi': 2, 'Perekayasa PL': 28, 'Start IT': 12, 'Marketing': 8, 'Usaha': 10 },
            instansi: { 'Pendidikan Tinggi': 15, 'Instansi Pemerintah': 25, 'Perusahaan Swasta': 45, 'BUMN': 15 },
            table: [
                { tahun: 2021, jumlahLulusan: 180, terlacak: 50, infokom: 40, nonInfokom: 10, multi: 1, nasional: 48, wirausaha: 1 },
                { tahun: 2022, jumlahLulusan: 190, terlacak: 90, infokom: 60, nonInfokom: 30, multi: 3, nasional: 85, wirausaha: 2 },
                { tahun: 2023, jumlahLulusan: 210, terlacak: 80, infokom: 55, nonInfokom: 25, multi: 2, nasional: 76, wirausaha: 2 },
                { tahun: 2024, jumlahLulusan: 195, terlacak: 100, infokom: 70, nonInfokom: 30, multi: 4, nasional: 94, wirausaha: 2 }
            ]
        },
        'D2 PPLS': {
            profesi: { 'Lainnya': 30, 'Data Analyst': 5, 'Customer Service': 10, 'Product QA': 2, 'Teknisi': 3, 'Perekayasa PL': 25, 'Start IT': 8, 'Marketing': 7, 'Usaha': 10 },
            instansi: { 'Pendidikan Tinggi': 20, 'Instansi Pemerintah': 20, 'Perusahaan Swasta': 40, 'BUMN': 20 },
            table: [
                { tahun: 2021, jumlahLulusan: 150, terlacak: 40, infokom: 30, nonInfokom: 10, multi: 0, nasional: 38, wirausaha: 2 },
                { tahun: 2022, jumlahLulusan: 160, terlacak: 70, infokom: 50, nonInfokom: 20, multi: 2, nasional: 66, wirausaha: 2 },
                { tahun: 2023, jumlahLulusan: 170, terlacak: 60, infokom: 45, nonInfokom: 15, multi: 1, nasional: 57, wirausaha: 2 },
                { tahun: 2024, jumlahLulusan: 165, terlacak: 80, infokom: 60, nonInfokom: 20, multi: 3, nasional: 75, wirausaha: 2 }
            ]
        },
        'S2 MRTI': {
            profesi: { 'Lainnya': 15, 'Data Analyst': 15, 'Customer Service': 3, 'Product QA': 5, 'Teknisi': 2, 'Perekayasa PL': 35, 'Start IT': 15, 'Marketing': 5, 'Usaha': 5 },
            instansi: { 'Pendidikan Tinggi': 25, 'Instansi Pemerintah': 25, 'Perusahaan Swasta': 40, 'BUMN': 10 },
            table: [
                { tahun: 2021, jumlahLulusan: 100, terlacak: 30, infokom: 25, nonInfokom: 5, multi: 2, nasional: 28, wirausaha: 0 },
                { tahun: 2022, jumlahLulusan: 110, terlacak: 50, infokom: 40, nonInfokom: 10, multi: 3, nasional: 47, wirausaha: 0 },
                { tahun: 2023, jumlahLulusan: 120, terlacak: 45, infokom: 35, nonInfokom: 10, multi: 2, nasional: 42, wirausaha: 1 },
                { tahun: 2024, jumlahLulusan: 115, terlacak: 60, infokom: 50, nonInfokom: 10, multi: 4, nasional: 55, wirausaha: 1 }
            ]
        }
    };

    let profesiChart, instansiChart;

    // Initialize Charts
    function initializeCharts(prodiData) {
        if (profesiChart) profesiChart.destroy();
        if (instansiChart) instansiChart.destroy();

        profesiChart = new Chart(document.getElementById('sebaranProfesiChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(prodiData.profesi),
                datasets: [{
                    data: Object.values(prodiData.profesi),
                    backgroundColor: ['#d1d5db', '#f87171', '#facc15', '#34d399', '#60a5fa', '#3b82f6', '#f97316', '#a78bfa', '#f59e0b'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Grafik Sebaran Profesi Lulusan',
                        font: { size: 16, weight: '600' },
                        color: '#1e3a8a',
                        padding: { bottom: 10 }
                    },
                    legend: {
                        position: 'right',
                        labels: {
                            font: { size: 12 },
                            color: '#374151',
                            padding: 12,
                            boxWidth: 12
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) label += ': ';
                                return label + context.raw + '%';
                            }
                        }
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeInOutQuad'
                }
            }
        });

        instansiChart = new Chart(document.getElementById('sebaranInstansiChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(prodiData.instansi),
                datasets: [{
                    data: Object.values(prodiData.instansi),
                    backgroundColor: ['#fde047', '#f87171', '#60a5fa', '#34d399'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Grafik Sebaran Jenis Instansi',
                        font: { size: 16, weight: '600' },
                        color: '#1e3a8a',
                        padding: { bottom: 10 }
                    },
                    legend: {
                        position: 'right',
                        labels: {
                            font: { size: 12 },
                            color: '#374151',
                            padding: 12,
                            boxWidth: 12
                        }
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeInOutQuad'
                }
            }
        });
    }

    // Update Table (simplified without percentages)
    function updateTable(prodiData, tahunAwal, tahunAkhir) {
        const tbody = document.getElementById('table-body');
        const tfoot = document.getElementById('table-footer');
        tbody.innerHTML = '';
        
        let totals = {
            jumlahLulusan: 0,
            terlacak: 0,
            infokom: 0,
            nonInfokom: 0,
            multi: 0,
            nasional: 0,
            wirausaha: 0
        };

        prodiData.table.forEach(row => {
            if (row.tahun >= tahunAwal && row.tahun <= tahunAkhir) {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.tahun}</td>
                    <td>${row.jumlahLulusan.toLocaleString()}</td>
                    <td>${row.terlacak.toLocaleString()}</td>
                    <td>${row.infokom.toLocaleString()}</td>
                    <td>${row.nonInfokom.toLocaleString()}</td>
                    <td>${row.multi.toLocaleString()}</td>
                    <td>${row.nasional.toLocaleString()}</td>
                    <td>${row.wirausaha.toLocaleString()}</td>
                `;
                tbody.appendChild(tr);

                // Update totals
                totals.jumlahLulusan += row.jumlahLulusan;
                totals.terlacak += row.terlacak;
                totals.infokom += row.infokom;
                totals.nonInfokom += row.nonInfokom;
                totals.multi += row.multi;
                totals.nasional += row.nasional;
                totals.wirausaha += row.wirausaha;
            }
        });

        // Add totals row
        tfoot.innerHTML = `
            <tr>
                <td>Total</td>
                <td>${totals.jumlahLulusan.toLocaleString()}</td>
                <td>${totals.terlacak.toLocaleString()}</td>
                <td>${totals.infokom.toLocaleString()}</td>
                <td>${totals.nonInfokom.toLocaleString()}</td>
                <td>${totals.multi.toLocaleString()}</td>
                <td>${totals.nasional.toLocaleString()}</td>
                <td>${totals.wirausaha.toLocaleString()}</td>
            </tr>
        `;
    }

    // Initial Load
    initializeCharts(dataByProdi['D4 TI']);
    updateTable(dataByProdi['D4 TI'], {{ $tahunAwalDefault }}, {{ $tahunAkhirDefault }});

    // Filter Handler
    document.getElementById('apply-filter').addEventListener('click', function() {
        const prodi = document.getElementById('prodi').value;
        const tahunAwal = parseInt(document.getElementById('tahun_awal').value);
        const tahunAkhir = parseInt(document.getElementById('tahun_akhir').value);

        if (tahunAwal > tahunAkhir) {
            alert('Tahun Awal tidak boleh lebih besar dari Tahun Akhir!');
            return;
        }

        document.getElementById('prodi-display').textContent = prodi;
        document.getElementById('tahun-display').textContent = `${tahunAwal} - ${tahunAkhir}`;

        initializeCharts(dataByProdi[prodi]);
        updateTable(dataByProdi[prodi], tahunAwal, tahunAkhir);
    });
</script>
@endsection