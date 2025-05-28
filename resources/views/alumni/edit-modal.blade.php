<!-- Modal Edit Alumni -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-transparent bg-opacity-50" id="editModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; backdrop-filter: blur(5px);">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 relative z-10">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Data Alumni</h3>
            <button type="button" onclick="closeEditModal()" class="text-red-600 hover:text-red-900 text-2xl">&times;</button>
        </div>

        <!-- Modal Body -->
        <form id="editForm" method="POST" action="">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Basic Information -->
                <div>
                    <x-input-label for="nama" value="Nama" />
                    <x-input id="nama" class="block mt-1 w-full" type="text" name="nama" required />
                </div>
                <div>
                    <x-input-label for="nim" value="NIM" />
                    <x-input id="nim" class="block mt-1 w-full" type="text" name="nim" required />
                </div>
                <div>
                    <x-input-label for="prodi" value="Program Studi" />
                    <select id="prodi" name="prodi" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                        <option value="">Loading program studi...</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" required />
                </div>
                <div>
                    <x-input-label for="no_hp" value="No. HP" />
                    <x-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" />
                </div>
                
                <!-- Institution Information -->
                <div>
                    <x-input-label for="jenis_instansi" value="Jenis Instansi" />
                    <x-input id="jenis_instansi" class="block mt-1 w-full" type="text" name="jenis_instansi" />
                </div>
                <div>
                    <x-input-label for="nama_instansi" value="Nama Instansi" />
                    <x-input id="nama_instansi" class="block mt-1 w-full" type="text" name="nama_instansi" />
                </div>
                <div>
                    <x-input-label for="skala_instansi" value="Skala Instansi" />
                    <x-input id="skala_instansi" class="block mt-1 w-full" type="text" name="skala_instansi" />
                </div>
                <div>
                    <x-input-label for="lokasi_instansi" value="Lokasi Instansi" />
                    <x-input id="lokasi_instansi" class="block mt-1 w-full" type="text" name="lokasi_instansi" />
                </div>
                
                <!-- Profession Information -->
                <div>
                    <x-input-label for="kategori_profesi" value="Kategori Profesi" />
                    <x-input id="kategori_profesi" class="block mt-1 w-full" type="text" name="kategori_profesi" />
                </div>
                <div>
                    <x-input-label for="profesi" value="Profesi" />
                    <x-input id="profesi" class="block mt-1 w-full" type="text" name="profesi" />
                </div>
                
                <!-- Graduation Information -->
                <div>
                    <x-input-label for="tanggal_lulus" value="Tanggal Lulus" />
                    <x-input id="tanggal_lulus" class="block mt-1 w-full" type="date" name="tanggal_lulus" />
                </div>
                {{-- <div>
                    <x-input-label for="tahun_lulus" value="Tahun Lulus" />
                    <x-input id="tahun_lulus" class="block mt-1 w-full" type="date" name="tahun_lulus" />
                </div> --}}
                <div>
                    <x-input-label for="tanggal_pertama_kerja" value="Tanggal Pertama Kerja" />
                    <x-input id="tanggal_pertama_kerja" class="block mt-1 w-full" type="date" name="tanggal_pertama_kerja" />
                </div>
                
                <!-- Additional Information -->
                {{-- <div>
                    <x-input-label for="token" value="Token" />
                    <x-input id="token" class="block mt-1 w-full" type="text" name="token" />
                </div> --}}
                <div>
                    <x-input-label for="is_infokom" value="Infokom" />
                    <select id="is_infokom" name="is_infokom" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-4">
                <button type="submit" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>