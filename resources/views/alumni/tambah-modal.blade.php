<!-- Modal Tambah Alumni -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-transparent bg-opacity-50" id="createModal" style="display: none;">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 relative z-10">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Tambah Data Alumni</h3>
            <button type="button" onclick="closeCreateModal()" class="text-red-600 hover:text-red-900 text-2xl">&times;</button>
        </div>

        <!-- Modal Body -->
        <form id="createForm" method="POST" action="{{ route('alumni.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Basic Information -->
                <div>
                    <x-input-label for="create_nama" value="Nama" />
                    <x-input id="create_nama" class="block mt-1 w-full" type="text" name="nama" required />
                </div>
                <div>
                    <x-input-label for="create_nim" value="NIM" />
                    <x-input id="create_nim" class="block mt-1 w-full" type="text" name="nim" required />
                </div>
                <div>
                    <x-input-label for="create_prodi" value="Program Studi" />
                    <select id="create_prodi" name="prodi_id" class="block mt-1 w-full" required>
                        <option value="">Pilih Program Studi</option>
                        @foreach($programStudi as $prodi)
                            <option value="{{ $prodi->prodi_id }}">{{ $prodi->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="create_email" value="Email" />
                    <x-input id="create_email" class="block mt-1 w-full" type="email" name="email" required />
                </div>
                <div>
                    <x-input-label for="create_no_hp" value="No. HP" />
                    <x-input id="create_no_hp" class="block mt-1 w-full" type="text" name="no_hp" />
                </div>

                <!-- Institution Information -->
                <div>
                    <x-input-label for="create_jenis_instansi" value="Jenis Instansi" />
                    <x-input id="create_jenis_instansi" class="block mt-1 w-full" type="text" name="jenis_instansi" />
                </div>
                <div>
                    <x-input-label for="create_nama_instansi" value="Nama Instansi" />
                    <x-input id="create_nama_instansi" class="block mt-1 w-full" type="text" name="nama_instansi" />
                </div>
                <div>
                    <x-input-label for="create_skala_instansi" value="Skala Instansi" />
                    <x-input id="create_skala_instansi" class="block mt-1 w-full" type="text" name="skala_instansi" />
                </div>
                <div>
                    <x-input-label for="create_lokasi_instansi" value="Lokasi Instansi" />
                    <x-input id="create_lokasi_instansi" class="block mt-1 w-full" type="text" name="lokasi_instansi" />
                </div>

                <!-- Profession Information -->
                <div>
                    <x-input-label for="create_kategori_profesi" value="Kategori Profesi" />
                    <x-input id="create_kategori_profesi" class="block mt-1 w-full" type="text" name="kategori_profesi" />
                </div>
                <div>
                    <x-input-label for="create_profesi" value="Profesi" />
                    <x-input id="create_profesi" class="block mt-1 w-full" type="text" name="profesi" />
                </div>

                <!-- Graduation Information -->
                <div>
                    <x-input-label for="create_tanggal_lulus" value="Tanggal Lulus" />
                    <x-input id="create_tanggal_lulus" class="block mt-1 w-full" type="date" name="tanggal_lulus" />
                </div>
                <div>
                    <x-input-label for="create_tanggal_pertama_kerja" value="Tanggal Pertama Kerja" />
                    <x-input id="create_tanggal_pertama_kerja" class="block mt-1 w-full" type="date" name="tanggal_pertama_kerja" />
                </div>

                <!-- Additional Information -->
                <div>
                    <x-input-label for="create_is_infokom" value="Infokom" />
                    <select id="create_is_infokom" name="is_infokom" class="block mt-1 w-full">
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

<script>
// Function to open the create modal
function openCreateModal() {
    document.getElementById('createModal').style.display = 'flex';
}

// Function to close the create modal
function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
}

// Handle form submission
document.getElementById('createForm').addEventListener('submit', function(e) {
    e.preventDefault();  // Prevent the default form submission

    const formData = new FormData(this);  // Collect all form data

    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, // Add CSRF token
        },
        body: formData,  // Send formData directly without converting to JSON
    })
    .then(response => response.json())  // Handle response as JSON
    .then(data => {
        if (data.success) {
            alert('Data alumni berhasil ditambahkan');
            closeCreateModal();
            window.location.reload();  // Reload the page after success
        } else {
            alert(data.message || 'Gagal menambahkan data');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Terjadi kesalahan saat menambahkan data');
    });
});
</script>