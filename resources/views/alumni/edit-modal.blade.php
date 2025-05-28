<!-- Modal Edit Alumni -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" id="editModal"
    style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 relative z-10 max-h-[90vh] overflow-y-auto">
        <!-- Modal Header with Close Button -->
        <div class="flex justify-between items-center mb-4 sticky top-0 bg-white py-2">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Data Alumni</h3>
            <button type="button" onclick="closeModal('editModal')" class="text-red-600 hover:text-red-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Basic Information -->
                <div>
                    <label class="text-sm text-gray-600">Nama</label>
                    <input type="text" name="nama" id="nama" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="text-sm text-gray-600">NIM</label>
                    <input type="text" name="nim" id="nim" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Program Studi</label>
                    <select name="prodi_id" id="prodi" class="w-full border rounded p-2" required>
                        <option value="">Loading...</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" id="email" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">No. HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="w-full border rounded p-2">
                </div>

                <!-- Institution Information -->
                <div>
                    <label class="text-sm text-gray-600">Jenis Instansi</label>
                    <input type="text" name="jenis_instansi" id="jenis_instansi" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Nama Instansi</label>
                    <input type="text" name="nama_instansi" id="nama_instansi" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Skala Instansi</label>
                    <input type="text" name="skala_instansi" id="skala_instansi" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Lokasi Instansi</label>
                    <input type="text" name="lokasi_instansi" id="lokasi_instansi" class="w-full border rounded p-2">
                </div>

                <!-- Profession Information -->
                <div>
                    <label class="text-sm text-gray-600">Kategori Profesi</label>
                    <input type="text" name="kategori_profesi" id="kategori_profesi"
                        class="w-full border rounded p-2">
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Pekerjaan</label>
                    <input type="text" name="profesi" id="profesi" class="w-full border rounded p-2">
                </div>

                <!-- Graduation Information -->
                <div>
                    <label class="text-sm text-gray-600">Tanggal Lulus</label>
                    <input type="date" name="tanggal_lulus" id="tanggal_lulus" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Tanggal Pertama Kerja</label>
                    <input type="date" name="tanggal_pertama_kerja" id="tanggal_pertama_kerja"
                        class="w-full border rounded p-2">
                </div>

                <!-- Additional Information -->
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Token</label>
                    <input type="text" name="token" id="token" class="w-full border rounded p-2">
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <x-primary-button>
                    Submit
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
