<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 w-full">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('assets/img/logo/polinema.png') }}" alt="logo-polinema" width="80">
                </div>
                <h2 class="text-center text-blue-900 font-bold">Formulir Tracer Study Alumni</h2>
                <div class="flex justify-center">
                    <div class="w-11/12 md:w-3/4 lg:w-1/2 max-w-2xl mx-auto">
                        <form method="POST" action="{{ url('/form-alumni/' . $alumni->token) }}" class="space-y-4">
                            @csrf
                            <label class="block text-blue-700 font-semibold text-center">Hello, <span
                                    class="font-normal">{{ $alumni->nama }}</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nama_instansi" class="text-sm text-gray-600">Nama Instansi</label>
                                    <input type="text" name="nama_instansi" id="nama_instansi" required
                                        class="w-full border rounded p-2" />
                                </div>
                                <div>
                                    <label for="lokasi_instansi" class="text-sm text-gray-600">Lokasi Instansi</label>
                                    <input type="text" name="lokasi_instansi" id="lokasi_instansi" required
                                        class="w-full border rounded p-2" />
                                </div>
                                <div>
                                    <label for="skala_instansi" class="text-sm text-gray-600">Skala Instansi</label>
                                    <select name="skala_instansi" id="skala_instansi" required
                                        class="w-full border rounded p-2">
                                        <option value="" disabled selected>--Pilih Skala Instansi--</option>
                                        <option value="Internasional">Internasional</option>
                                        <option value="Nasional">Nasional</option>
                                        <option value="Wirausaha">Wirausaha</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="jenis_instansi" class="text-sm text-gray-600">Jenis Instansi</label>
                                    <select name="jenis_instansi" id="jenis_instansi" required
                                        class="w-full border rounded p-2">
                                        <option value="" disabled selected>--Pilih Jenis Instansi--</option>
                                        <option value="Pendidikan">Pendidikan</option>
                                        <option value="Pemerintahan">Pemerintahan</option>
                                        <option value="Swasta">Swasta</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="kategori_profesi" class="text-sm text-gray-600">Kategori Profesi</label>
                                    <select name="kategori_profesi" id="kategori_profesi" required
                                        class="w-full border rounded p-2">
                                        <option value="" disabled selected>--Pilih Kategori Instansi--</option>
                                        <option value="Infokom">Infokom</option>
                                        <option value="Non Infokom">Non Infokom</option>
                                        <option value="Tidak Bekerja">Tidak Bekerja</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="tanggal_pertama_kerja" class="text-sm text-gray-600">Tanggal Pertama Kerja</label>
                                    <input type="date" name="tanggal_pertama_kerja" id="tanggal_pertama_kerja"
                                        class="w-full border rounded p-2" />
                                </div>
                                <div class="md:col-span-2">
                                    <label for="profesi" class="text-sm text-gray-600">Profesi</label>
                                    <select name="profesi" id="profesi" required class="w-full border rounded p-2">
                                        <option value="" disabled selected>--Pilih profesi--</option>
                                    </select>
                                    <input type="text" name="profesi_lainnya" id="profesi_lainnya" placeholder="Masukkan Profesi"
                                        class="w-full border rounded p-2 mt-2 hidden" />
                                </div>
                            </div>

                            <h3 class="text-blue-600 font-bold mt-6">Informasi Atasan <span
                                    class="text-gray-500 text-sm">(Opsional)</span></h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nama_atasan" class="text-sm text-gray-600">Nama Atasan</label>
                                    <input type="text" name="nama_atasan" id="nama_atasan"
                                        class="w-full border rounded p-2" />
                                </div>
                                <div>
                                    <label for="jabatan_atasan" class="text-sm text-gray-600">Jabatan Atasan</label>
                                    <input type="text" name="jabatan_atasan" id="jabatan_atasan"
                                        class="w-full border rounded p-2" />
                                </div>
                                <div>
                                    <label for="email_atasan" class="text-sm text-gray-600">Email Atasan</label>
                                    <input type="email" name="email_atasan" id="email_atasan"
                                        class="w-full border rounded p-2" />
                                </div>
                                <div>
                                    <label for="no_hp_atasan" class="text-sm text-gray-600">No HP Atasan</label>
                                    <input type="text" name="no_hp_atasan" id="no_hp_atasan"
                                        class="w-full border rounded p-2" />
                                </div>
                            </div>
                            <div class="flex justify-end mt-4">
                                <x-primary-button>
                                    Submit
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
            @push('scripts')
                <script src="{{ asset('assets/js/data-alumni.js') }}"></script>
            @endpush
</x-app-layout>