<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<x-app-layout>
    <x-slot name="header">
        <!-- Header tetap seperti asli -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight whitespace-nowrap">
                {{ __('Dashboard') }}
            </h2>
            <x-filter />
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex gap-6">
                <!-- Baris 1 - Line Chart Jumlah Responden -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" style="width: 75%">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">Responden Tracer Study</h3>
                    <div style="height: 20rem">
                        <canvas id="respondenChart"></canvas>
                    </div>
                </div>

                <!-- Baris 1 - Pie Chart Performa Lulusan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" style="width: 25%">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">Performa Lulusan</h3>
                    <div class="mb-4">
                        <select id="performanceParameter" class="border-gray-300 text-sm rounded-md shadow-sm w-full">
                            <option value="teamwork">Kerjasama Tim</option>
                            <option value="expertise">Keahlian di bidang TI</option>
                            <option value="language">Kemampuan berbahasa asing</option>
                            <option value="communication">Kemampuan berkomunikasi</option>
                            <option value="development">Pengembangan diri</option>
                            <option value="leadership">Kepemimpinan</option>
                            <option value="work_ethic">Etos Kerja</option>
                        </select>
                    </div>
                    <div class="h-64">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" style="width: 100%">
                <h2 class="font-semibold text-gray-700 mb-4 text-center">Kesesuaian & Lingkup Profesi Lulusan
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-4" rowspan="2">Tahun</th>
                                <th class="px-4 py-4" rowspan="2">Jumlah Lulusan</th>
                                <th class="px-4 py-4" rowspan="2">Lulusan Terlacak</th>
                                <th class="px-4 py-4" rowspan="2">Infokom</th>
                                <th class="px-4 py-4" rowspan="2">Non Infokom</th>
                                <th class="px-4 py-4 text-center border-b border-gray-200" colspan="3">Lingkup
                                    Profesi Lulusan</th>
                            </tr>
                            <tr>
                                <th class="px-4 py-4">Internasional</th>
                                <th class="px-4 py-4">Nasional</th>
                                <th class="px-4 py-4">Wirausaha</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">

                        </tbody>
                    </table>
                </div>
            </div>



            <!-- Bar Chart 10 Pekerjaan Terbanyak (Full Width) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" style="width: 100%">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">10 Pekerjaan Terbanyak Alumni</h3>
                <div style="height: 24rem">
                    <canvas id="pekerjaanChart"></canvas>
                </div>
            </div>

            <!-- Baris Terakhir - 50% 50% -->
            <div class="flex gap-6">
                <!-- Pie Chart - Sebaran Instansi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" style="width: 25%">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">Sebaran Instansi</h3>
                    <div class="h-64">
                        <canvas id="instansiChart"></canvas>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" style="width: 25%">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">Alumni Terlacak</h3>
                    <div class="h-64">
                        <canvas id="terlacakChart"></canvas>
                    </div>
                </div>

                <!-- Tabel - Masa Tunggu Lulusan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" style="width: 50%">
                    <h2 class="font-semibold text-gray-700 mb-4 text-center">Masa Tunggu Lulusan</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-500 uppercase border-b">
                                <tr>
                                    <th class="px-4 py-2">Tahun</th>
                                    <th class="px-4 py-2">Jumlah Lulusan</th>
                                    <th class="px-4 py-2">Terlacak</th>
                                    <th class="px-4 py-2">Masa Tunggu</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <!-- Data tabel -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



        </div>
    </div>

    {{-- CHART SCRIPT --}}
    <script>
        // Performance data for different parameters
        const performanceData = @json($performanceData);

        // Pie Chart for Performance
        const performanceCtx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(performanceCtx, {
            type: 'pie',
            data: {
                labels: ['Kurang', 'Cukup', 'Baik', 'Sangat Baik'],
                datasets: [{
                    data: performanceData.teamwork,
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(249, 115, 22, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Event listener for parameter change
        document.getElementById('performanceParameter').addEventListener('change', function() {
            const selectedParameter = this.value;
            performanceChart.data.datasets[0].data = performanceData[selectedParameter];
            performanceChart.update();
        });

        // Line Chart Jumlah Responden
        const respondenCtx = document.getElementById('respondenChart').getContext('2d');

        new Chart(respondenCtx, {
            type: 'line',
            data: {
                labels: @json($respondenLabels),
                datasets: [{
                    label: 'Jumlah Responden',
                    data: @json($respondenCounts),
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.05)',
                    tension: 0.3,
                    fill: true,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });

        // Pie Chart - Sebaran Instansi
        const instansiCtx = document.getElementById('instansiChart').getContext('2d');
        new Chart(instansiCtx, {
            type: 'pie',
            data: {
                labels: ['Swasta', 'Pemerintah', 'Pendidikan', 'Lainnya'],
                datasets: [{
                    data: @json($instansiCounts),
                    backgroundColor: [
                        'rgba(79, 70, 229, 0.7)',
                        'rgba(236, 72, 153, 0.7)',
                        'rgba(249, 115, 22, 0.7)',
                        'rgba(59, 130, 246, 0.7)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
        // Pie Chart - Sebaran Instansi
        // Pie Chart - Terlacak vs Tidak Terlacak
        const terlacakCtx = document.getElementById('terlacakChart').getContext('2d');
        new Chart(terlacakCtx, {
            type: 'pie',
            data: {
                labels: ['Terlacak ', 'Tidak Terlacak'],
                datasets: [{
                    data: @json($terlacakCounts),
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.7)', // Terlacak - hijau
                        'rgba(239, 68, 68, 0.7)' // Tidak Terlacak - merah
                    ],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        const pekerjaanCtx = document.getElementById('pekerjaanChart').getContext('2d');
        new Chart(pekerjaanCtx, {
            type: 'bar',
            data: {
                labels: @json($pekerjaanLabels),
                datasets: [{
                    label: 'Jumlah Alumni',

                    data: @json($pekerjaanCounts),

                    backgroundColor: 'rgba(79, 70, 229, 0.7)',
                    borderColor: 'rgb(79, 70, 229)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
