<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 w-full">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('assets/img/logo/polinema.png') }}" alt="logo-polinema" width="80">
                </div>
                <h2 class="text-center text-blue-900 font-bold">Formulir Evaluasi Pengguna Lulusan</h2>
                <div class="flex justify-center">
                    <div class="w-11/12 md:w-3/4 lg:w-1/2 max-w-2xl mx-auto">
                        <form method="POST" action="{{ url('/form-pengguna/' . $pengguna->token) }}" class="space-y-4">
                            @csrf
                            <label class="block text-blue-700 font-semibold text-center">Hello, <span
                                    class="font-normal">{{ $pengguna->nama }}</span></label>

                            <div class="mb-4">
                                <label for="tahun_kerja" class="text-blue-600 font-bold mt-6">Tahun Kerja</label>
                                <select id="tahun_kerja" name="tahun_kerja" required class="w-full border rounded p-2">
                                    <option value="" disabled selected>-- Pilih Tahun --</option>
                                    @foreach($tahunKerjaList as $tahun)
                                        <option value="{{ $tahun }}" {{ old('tahun_kerja') == $tahun ? 'selected' : '' }}>
                                            {{ $tahun }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tahun_kerja')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <h3 class="text-blue-600 font-bold mt-6">Perfoma Pengguna Lulusan</h3>
                                @php
                                    $aspek = [
                                        'kerjasama_tim' => 'Kerjasama Tim',
                                        'keahlian_ti' => 'Keahlian TI',
                                        'bahasa_asing' => 'Bahasa Asing',
                                        'komunikasi' => 'Komunikasi',
                                        'pengembangan_diri' => 'Pengembangan Diri',
                                        'kepemimpinan' => 'Kepemimpinan',
                                        'etos_kerja' => 'Etos Kerja',
                                    ];
                                $opsi = [
                                        '1' => 'Kurang',
                                        '2' => 'Cukup',
                                        '3' => 'Baik',
                                        '4' => 'Sangat Baik'
                                    ];
                                @endphp

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                @foreach ($aspek as $field => $label)
                                    <div class="border p-4 rounded shadow-sm bg-white">
                                        <label class="block font-semibold mb-2 text-gray-700">{{ $label }}</label>
                                        <div class="flex flex-wrap gap-4">
                                            @foreach ($opsi as $value => $text)
                                                <label class="inline-flex items-center space-x-1">
                                                    <input 
                                                    type="radio" 
                                                    name="{{ $field }}" 
                                                    value="{{ $value }}"
                                                    class="form-radio h-5 w-5 text-blue-600 mr-2"
                                                    {{ old($field) == $value ? 'checked' : '' }} required>
                                                    <span>{{ $text }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error($field)
                                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                            
                            <div>
                                <label for="kompetensi_kurang" class="block text-sm text-blue-600 font-bold">Kompetensi Kurang
                                    <span class="text-gray-400 text-sm">(Opsional)</span></label>
                                <textarea id="kompetensi_kurang" name="kompetensi_kurang" rows="3"
                                    class="w-full border rounded p-2">{{ old('kompetensi_kurang') }}</textarea>
                            </div>

                            <div>
                                <label for="saran_kurikulum" class="block text-sm text-blue-600 font-bold">Saran Kurikulum <span
                                        class="text-gray-400 text-sm">(Opsional)</span></label>
                                <textarea id="saran_kurikulum" name="saran_kurikulum" rows="3"
                                    class="w-full border rounded p-2">{{ old('saran_kurikulum') }}</textarea>
                            </div>

                            <div class="flex justify-end mt-4">
                                <x-primary-button>
                                    Simpan
                                </x-primary-button>
                            </div>
                            @if (session('success'))
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses!',
                                    text: '{{ session('success') }}',
                                    confirmButtonText: 'OK'
                                });
                            </script>
                        @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>