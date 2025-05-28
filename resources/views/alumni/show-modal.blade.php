<!-- Modal Show Alumni -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" id="showModal"
    style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 relative z-10 max-h-[90vh] overflow-y-auto">
        <!-- Modal Header with Close Button on the right -->
        <div class="flex justify-between items-center mb-4 sticky top-0 bg-white py-2">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Detail Alumni</h3>
            <button type="button" onclick="closeModal('showModal')" class="text-red-600 hover:text-red-900"
                style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Basic Information -->
            <div>
                <p class="text-sm text-gray-500">Nama:</p>
                <p class="text-sm font-medium text-gray-900" id="showNama">-</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">NIM:</p>
                <p class="text-sm font-medium text-gray-900" id="showNIM">-</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Program Studi:</p>
                <p class="text-sm font-medium text-gray-900" id="showProdi">-</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email:</p>
                <p class="text-sm font-medium text-gray-900" id="showEmail">-</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">No. HP:</p>
                <p class="text-sm font-medium text-gray-900" id="showNoHP">-</p>
            </div>

            <!-- Institution Information -->
            <div>
                <p class="text-sm text-gray-500">Jenis Instansi:</p>
                <p class="text-sm font-medium text-gray-900" id="showJenisInstansi">-</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nama Instansi:</p>
                <p class="text-sm font-medium text-gray-900" id="showNamaInstansi">-</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Skala Instansi:</p>
                <p class="text-sm font-medium text-gray-900" id="showSkalaInstansi">-</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Lokasi Instansi:</p>
                <p class="text-sm font-medium text-gray-900" id="showLokasiInstansi">-</p>
            </div>

            <!-- Profession Information -->
            <div>
                <p class="text-sm text-gray-500">Kategori Profesi:</p>
                <p class="text-sm font-medium text-gray-900" id="showKategoriProfesi">-</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Pekerjaan:</p>
                <p class="text-sm font-medium text-gray-900" id="showPekerjaan">-</p>
            </div>

            <!-- Graduation Information -->
            <div>
                <p class="text-sm text-gray-500">Tanggal Lulus:</p>
                <p class="text-sm font-medium text-gray-900" id="showTanggalLulus">-</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tanggal Pertama Kerja:</p>
                <p class="text-sm font-medium text-gray-900" id="showTanggalKerja">-</p>
            </div>

            <!-- Additional Information -->
            <div>
                <p class="text-sm text-gray-500">Token:</p>
                <p class="text-sm font-medium text-gray-900" id="showToken">-</p>
            </div>
        </div>
    </div>
</div>
