<x-app-layout>
    <div class="py-4">
        <div class="max-w-xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 w-full">
                <!-- Logo Polinema -->
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('assets/img/logo/polinema.png') }}" alt="logo-polinema" width="60">
                </div>

                <!-- Judul -->
                <h2 class="text-center text-blue-900 font-bold text-lg mb-4">Data Anda Telah Terekam</h2>
                
                <!-- Greeting -->
                <div class="flex justify-center mb-4">
                    <label class="block text-blue-700 font-semibold text-sm text-center">
                        Hello, <span class="font-normal">{{ $alumni->nama }}</span>
                    </label>
                </div>

                <div class="space-y-4">
                    <!-- Data Alumni -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="md:pr-2">
                            <label class="text-xs text-gray-600">Nama Instansi</label>
                            <div class="border rounded p-2 bg-gray-50 text-xs min-h-[50px] flex items-center">
                                {{ $alumni->nama_instansi }}
                            </div>
                        </div>
                        <div class="md:pl-2">
                            <label class="text-xs text-gray-600">Lokasi Instansi</label>
                            <div class="border rounded p-2 bg-gray-50 text-xs min-h-[50px] flex items-center">
                                {{ $alumni->lokasi_instansi }}
                            </div>
                        </div>
                        <div class="md:pr-2">
                            <label class="text-xs text-gray-600">Skala Instansi</label>
                            <div class="border rounded p-2 bg-gray-50 text-xs min-h-[50px] flex items-center">
                                {{ $alumni->skala_instansi }}
                            </div>
                        </div>
                        <div class="md:pl-2">
                            <label class="text-xs text-gray-600">Jenis Instansi</label>
                            <div class="border rounded p-2 bg-gray-50 text-xs min-h-[50px] flex items-center">
                                {{ $alumni->jenis_instansi }}
                            </div>
                        </div>
                        <div class="md:pr-2">
                            <label class="text-xs text-gray-600">Kategori Profesi</label>
                            <div class="border rounded p-2 bg-gray-50 text-xs min-h-[50px] flex items-center">
                                {{ $alumni->kategori_profesi }}
                            </div>
                        </div>
                        <div class="md:pl-2">
                            <label class="text-xs text-gray-600">Tanggal Pertama Kerja</label>
                            <div class="border rounded p-2 bg-gray-50 text-xs min-h-[50px] flex items-center">
                                {{ $alumni->tanggal_pertama_kerja ? \Carbon\Carbon::parse($alumni->tanggal_pertama_kerja)->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label class="text-xs text-gray-600">Profesi</label>
                            <div class="border rounded p-2 bg-gray-50 text-xs min-h-[50px] flex items-center w-full">
                                {{ $alumni->profesi }}
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Atasan -->
                    <h3 class="text-blue-600 font-bold text-sm mt-4">
                        Informasi Atasan <span class="text-gray-500 text-xs">(Opsional)</span>
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="md:pr-2">
                            <label class="text-xs text-gray-600">Nama Atasan</label>
                            <div class="border rounded p-2 bg-gray-50 text-xs min-h-[50px] flex items-center">
                                {{ $alumni->nama_atasan ?? '-' }}
                            </div>
                        </div>
                        <div class="md:pl-2">
                            <label class="text-xs text-gray-600">Jabatan Atasan</label>
                            <div class="border rounded p-2 bg-gray-50 text-xs min-h-[50px] flex items-center">
                                {{ $alumni->jabatan_atasan ?? '-' }}
                            </div>
                        </div>
                        <div class="md:pr-2">
                            <label class="text-xs text-gray-600">Email Atasan</label>
                            <div class="border rounded p-2 bg-gray-50 text-xs min-h-[50px] flex items-center">
                                {{ $alumni->email_atasan ?? '-' }}
                            </div>
                        </div>
                        <div class="md:pl-2">
                            <label class="text-xs text-gray-600">No HP Atasan</label>
                            <div class="border rounded p-2 bg-gray-50 text-xs min-h-[50px] flex items-center">
                                {{ $alumni->no_hp_atasan ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="flex justify-end mt-3">
                        <a href="{{ url('/') }}"
                           class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>