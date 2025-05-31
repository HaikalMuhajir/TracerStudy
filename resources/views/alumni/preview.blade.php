<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 w-full">
                <!-- Logo Polinema -->
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('assets/img/logo/polinema.png') }}" alt="logo-polinema" width="60" class="h-auto">
                </div>

                <!-- Judul -->
                <h2 class="text-center text-blue-900 font-bold text-xl mb-4">Data Anda Telah Terekam</h2>

                <!-- Data Alumni -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-800 justify-center">
                    <div class="border p-2 rounded-lg bg-gray-50 w-full max-w-[120px]">
                        <div class="font-semibold text-gray-700">Nama:</div>
                        <div>{{ $alumni->nama }}</div>
                    </div>
                    <div class="border p-2 rounded-lg bg-gray-50 w-full max-w-[120px] mx-auto">
                        <div class="font-semibold text-gray-700">Profesi:</div>
                        <div>{{ $alumni->profesi }}</div>
                    </div>
                    <div class="border p-2 rounded-lg bg-gray-50 w-full max-w-[120px] mx-auto">
                        <div class="font-semibold text-gray-700">Nama Instansi:</div>
                        <div>{{ $alumni->nama_instansi }}</div>
                    </div>
                    <div class="border p-2 rounded-lg bg-gray-50 w-full max-w-[120px] mx-auto">
                        <div class="font-semibold text-gray-700">Jenis Instansi:</div>
                        <div>{{ $alumni->jenis_instansi }}</div>
                    </div>
                    <div class="border p-2 rounded-lg bg-gray-50 w-full max-w-[120px] mx-auto">
                        <div class="font-semibold text-gray-700">Kategori Profesi:</div>
                        <div>{{ $alumni->kategori_profesi }}</div>
                    </div>
                    <div class="border p-2 rounded-lg bg-gray-50 w-full max-w-[120px] mx-auto">
                        <div class="font-semibold text-gray-700">Tanggal Pertama Kerja:</div>
                        <div>{{ $alumni->tanggal_pertama_kerja }}</div>
                    </div>
                </div>

                <!-- Informasi Atasan -->
                <div class="mt-6">
                    <h3 class="text-blue-600 font-bold text-sm mb-2">
                        Informasi Atasan <span class="text-gray-500 text-xs">(Opsional)</span>
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-800 justify-center">
                        <div class="border p-2 rounded-lg bg-gray-50 w-full max-w-[120px] mx-auto">
                            <div class="font-semibold text-gray-700">Nama Atasan:</div>
                            <div>{{ $alumni->nama_atasan ?? '-' }}</div>
                        </div>
                        <div class="border p-2 rounded-lg bg-gray-50 w-full max-w-[120px] mx-auto">
                            <div class="font-semibold text-gray-700">Jabatan Atasan:</div>
                            <div>{{ $alumni->jabatan_atasan ?? '-' }}</div>
                        </div>
                        <div class="border p-2 rounded-lg bg-gray-50 w-full max-w-[120px] mx-auto">
                            <div class="font-semibold text-gray-700">Email Atasan:</div>
                            <div>{{ $alumni->email_atasan ?? '-' }}</div>
                        </div>
                        <div class="border p-2 rounded-lg bg-gray-50 w-full max-w-[120px] mx-auto">
                            <div class="font-semibold text-gray-700">No HP Atasan:</div>
                            <div>{{ $alumni->nohp_atasan ?? '-' }}</div>
                        </div>
                    </div>
                </div>              

                <!-- Tombol Kembali -->
                <div class="flex justify-end mt-4">
                    <a href="{{ url('/') }}" class="text-blue-600 hover:underline text-sm">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>