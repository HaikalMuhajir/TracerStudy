<x-app-layout>
    <div class="py-4">
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 w-full max-w-xl">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('assets/img/logo/polinema.png') }}" alt="logo-polinema" width="60">
                </div>
                <h2 class="text-center text-blue-900 font-bold text-lg mb-4">Formulir Evaluasi Pengguna Lulusan</h2>
                <div class="flex justify-center mb-4">
                    <label class="block text-blue-700 font-semibold text-sm text-center">
                        Hello, <span class="font-normal">{{ $pengguna->nama }}</span>
                    </label>
                </div>

                {{-- Form untuk memilih tahun --}}
                <form method="GET" action="{{ url('/form-pengguna/' . $pengguna->token) }}" class="mb-4">
                    <label for="tahun_kerja" class="text-blue-600 font-bold text-sm">Tahun Kerja</label>
                    <select id="tahun_kerja" name="tahun" required onchange="this.form.submit()"
                        class="w-full border rounded p-2 text-xs">
                        <option value="" disabled {{ $selectedYear ? '' : 'selected' }}>-- Pilih Tahun --</option>
                        @foreach ($tahunKerjaList as $tahun)
                            <option value="{{ $tahun }}" {{ $selectedYear == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </form>

                @if ($selectedYear)
                    <div class="space-y-4">
                        <form method="POST" action="{{ url('/form-pengguna/' . $pengguna->token) }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="tahun_kerja" value="{{ $selectedYear }}">

                            <h3 class="text-blue-600 font-bold text-sm mt-4">Perfoma Pengguna Lulusan</h3>
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
                                    '4' => 'Sangat Baik',
                                ];
                            @endphp

                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse text-xs">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="border p-2 text-left font-semibold text-gray-700"
                                                style="width: 40%;">Aspek</th>
                                            @foreach ($opsi as $value => $text)
                                                <th class="border p-2 text-center font-semibold text-gray-700"
                                                    style="width: 15%;">{{ $text }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aspek as $field => $label)
                                            <tr>
                                                <td class="border p-2 text-gray-700">{{ $label }}</td>
                                                @foreach ($opsi as $value => $text)
                                                    <td class="border p-2 text-center">
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" name="{{ $field }}"
                                                                value="{{ $value }}"
                                                                class="form-radio h-4 w-4 text-blue-600 {{ $performaIsi ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                                {{ old($field, optional($performaIsi)->$field) == $value ? 'checked' : '' }}
                                                                {{ $performaIsi ? 'disabled' : '' }} required>
                                                        </label>
                                                    </td>
                                                @endforeach
                                            </tr>
                                            @error($field)
                                                <tr>
                                                    <td colspan="5" class="border p-2 text-red-600 text-xs">
                                                        {{ $message }}</td>
                                                </tr>
                                            @enderror
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <div>
                                    <label for="kompetensi_kurang" class="block text-sm text-blue-600 font-bold">
                                        Kompetensi Kurang <span class="text-gray-400 text-xs">(Opsional)</span>
                                    </label>
                                    <textarea id="kompetensi_kurang" name="kompetensi_kurang" rows="3"
                                        class="w-full border rounded p-2 text-xs {{ $performaIsi ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                        {{ $performaIsi ? 'readonly' : '' }}>{{ old('kompetensi_kurang', optional($performaIsi)->kompetensi_kurang) }}</textarea>
                                </div>
                                <div>
                                    <label for="saran_kurikulum" class="block text-sm text-blue-600 font-bold">
                                        Saran Kurikulum <span class="text-gray-400 text-xs">(Opsional)</span>
                                    </label>
                                    <textarea id="saran_kurikulum" name="saran_kurikulum" rows="3"
                                        class="w-full border rounded p-2 text-xs {{ $performaIsi ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                        {{ $performaIsi ? 'readonly' : '' }}>{{ old('saran_kurikulum', optional($performaIsi)->saran_kurikulum) }}</textarea>
                                </div>
                            </div>

                            @if (!$performaIsi)
                                <div class="flex justify-end mt-6">
                                    <x-primary-button>
                                        Submit
                                    </x-primary-button>
                                </div>
                            @else
                                <div class="text-green-600 text-sm mt-6 text-center">
                                    Data tahun {{ $selectedYear }} sudah terisi dan tidak dapat diubah.
                                </div>
                            @endif
                        </form>
                    </div>
                @endif

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
            </div>
        </div>
    </div>
</x-app-layout>
