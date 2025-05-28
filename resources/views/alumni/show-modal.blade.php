<!-- Modal Show Alumni -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-transparent bg-opacity-50" id="showModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; backdrop-filter: blur(5px);">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 relative z-10">
        <!-- Modal Header with Close Button on the right -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Detail Alumni</h3>
            <button type="button" onclick="closeModal()" class="text-red-600 hover:text-red-900 text-2xl">
                &times;
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Basic Information -->
            <div>
                <p class="text-sm text-gray-500">Nama:</p>
                <p class="text-sm font-medium text-gray-900" id="showNama"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">NIM:</p>
                <p class="text-sm font-medium text-gray-900" id="showNIM"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Program Studi:</p>
                <p class="text-sm font-medium text-gray-900" id="showProdi"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email:</p>
                <p class="text-sm font-medium text-gray-900" id="showEmail"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">No. HP:</p>
                <p class="text-sm font-medium text-gray-900" id="showNoHP"></p>
            </div>
            
            <!-- Institution Information -->
            <div>
                <p class="text-sm text-gray-500">Jenis Instansi:</p>
                <p class="text-sm font-medium text-gray-900" id="showJenisInstansi"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nama Instansi:</p>
                <p class="text-sm font-medium text-gray-900" id="showNamaInstansi"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Skala Instansi:</p>
                <p class="text-sm font-medium text-gray-900" id="showSkalaInstansi"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Lokasi Instansi:</p>
                <p class="text-sm font-medium text-gray-900" id="showLokasiInstansi"></p>
            </div>
            
            <!-- Profession Information -->
            <div>
                <p class="text-sm text-gray-500">Kategori Profesi:</p>
                <p class="text-sm font-medium text-gray-900" id="showKategoriProfesi"></p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Pekerjaan:</p>
                <p class="text-sm font-medium text-gray-900" id="showPekerjaan"></p>
            </div>
            
            <!-- Graduation Information -->
            <div>
                <p class="text-sm text-gray-500">Tanggal Lulus:</p>
                <p class="text-sm font-medium text-gray-900" id="showTanggalLulus"></p>
            </div>
            {{-- <div>
                <p class="text-sm text-gray-500">Tahun Lulus:</p>
                <p class="text-sm font-medium text-gray-900" id="showTahunLulus"></p>
            </div> --}}
            <div>
                <p class="text-sm text-gray-500">Tanggal Pertama Kerja:</p>
                <p class="text-sm font-medium text-gray-900" id="showTanggalKerja"></p>
            </div>
            
            <!-- Additional Information -->
            {{-- <div>
                <p class="text-sm text-gray-500">Token:</p>
                <p class="text-sm font-medium text-gray-900" id="showToken"></p>
            </div> --}}
            <div>
                <p class="text-sm text-gray-500">Infokom:</p>
                <p class="text-sm font-medium text-gray-900" id="showInfokom"></p>
            </div>
        </div>
    </div>
</div>
