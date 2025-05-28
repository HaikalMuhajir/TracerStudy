<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight whitespace-nowrap">
                {{ __('Data Alumni') }}
            </h2>
            <x-filter />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 w-full">
                <h2 class="font-semibold text-gray-700 mb-4 text-center">Data Alumni Tersedia</h2>
                <!-- Tombol Tambah Alumni -->
                <button onclick="openCreateModal()" class="bg-blue-500 text-black px-4 py-2 rounded mb-4">
                    Tambah Alumni
                </button>
                <div class="overflow-x-auto">
                    <table id="alumniTable" class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-4" rowspan="2">No</th>
                                <th class="px-4 py-4" rowspan="2">Nama</th>
                                <th class="px-4 py-4" rowspan="2">NIM</th>
                                <th class="px-4 py-4" rowspan="2">Program Studi</th>
                                <th class="px-4 py-4" rowspan="2">Email</th>
                                <th class="px-4 py-4 text-center border-b border-gray-200" colspan="3">Aksi</th>
                            </tr>
                            <tr>
                                <th class="px-4 py-4">Show</th>
                                <th class="px-4 py-4">Edit</th>
                                <th class="px-4 py-4 ">Delete</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach($alumni as $index => $alum)
                                <tr>
                                    <td class="px-4 py-4">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4">{{ $alum->nama }}</td>
                                    <td class="px-4 py-4">{{ $alum->nim }}</td>
                                    <td class="px-4 py-4">
                                        {{ $alum->programStudi->nama_prodi ?? 'N/A' }}
                                    </td>                                    
                                    <td class="px-4 py-4">{{ $alum->email }}</td>
                                    <td class="px-4 py-4">
                                        <!-- Tombol Show untuk membuka modal -->
                                        <a href="javascript:void(0)" onclick="openShowModal({{ $alum->alumni_id }})" class="text-blue-600 hover:text-blue-900">Show</a>
                                    </td>
                                    <td class="px-4 py-4">
                                        <!-- Tombol Show untuk membuka modal -->
                                        <a href="javascript:void(0)" onclick="openEditModal({{ $alum->alumni_id }})" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                    </td>                                    
                                    <td class="px-4 py-4">
                                        <form action="{{ route('alumni.destroy', $alum->alumni_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this alumni?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
 <!-- Modal Show Alumni -->
 @include('alumni.edit-modal', ['programStudi' => \App\Models\ProgramStudi::all()])
 @include('alumni.show-modal')
 @include('alumni.tambah-modal', ['programStudi' => \App\Models\ProgramStudi::all()])
</x-app-layout>
<script>
// Fungsi untuk membuka modal show dan menampilkan data alumni
function openShowModal(id) {
        fetch(`/alumni/${id}/show`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Debug data yang diterima
            console.log('Data dari server:', data);
            // Format tanggal jika diperlukan
            const formatDate = (dateString) => {
                if (!dateString) return '-';
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID');
            };

            // Basic Information
            document.getElementById('showNama').innerText = data.nama || '-';
            document.getElementById('showNIM').innerText = data.nim || '-';
            document.getElementById('showProdi').innerText = data.program_studi?.nama_prodi || 'N/A';            
            document.getElementById('showEmail').innerText = data.email || '-';
            document.getElementById('showNoHP').innerText = data.no_hp || '-';
            
            // Institution Information
            document.getElementById('showJenisInstansi').innerText = data.jenis_instansi || '-';
            document.getElementById('showNamaInstansi').innerText = data.nama_instansi || '-';
            document.getElementById('showSkalaInstansi').innerText = data.skala_instansi || '-';
            document.getElementById('showLokasiInstansi').innerText = data.lokasi_instansi || '-';
            
            // Profession Information
            document.getElementById('showKategoriProfesi').innerText = data.kategori_profesi || '-';
            document.getElementById('showPekerjaan').innerText = data.profesi || '-';
            
            // Graduation Information
            document.getElementById('showTanggalLulus').innerText = formatDate(data.tanggal_lulus);
            // document.getElementById('showTahunLulus').innerText = formatDate(data.tahun_lulus);
            document.getElementById('showTanggalKerja').innerText = formatDate(data.tanggal_pertama_kerja);
            
            // Additional Information
            // document.getElementById('showToken').innerText = data.token || '-';
            document.getElementById('showInfokom').innerText = data.is_infokom ? 'Ya' : 'Tidak';
            
            // Menampilkan modal
            document.getElementById('showModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat data alumni');
        });
    }
    
    // Fungsi untuk menutup modal
    function closeModal() {
        document.getElementById('showModal').style.display = 'none';
    }    

    function openEditModal(id) {
    const prodiSelect = document.getElementById('prodi');
    prodiSelect.innerHTML = '<option value="">Loading...</option>';
    
    fetch(`/alumni/${id}/edit`)
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        console.log('Data edit:', data); // Debugging
        
        // Isi data alumni
        document.getElementById('nama').value = data.alumni.nama || '';
        document.getElementById('nim').value = data.alumni.nim || '';
        document.getElementById('email').value = data.alumni.email || '';
        document.getElementById('no_hp').value = data.alumni.no_hp || '';
        document.getElementById('jenis_instansi').value = data.alumni.jenis_instansi || '';
        document.getElementById('nama_instansi').value = data.alumni.nama_instansi || '';
        document.getElementById('skala_instansi').value = data.alumni.skala_instansi || '';
        document.getElementById('lokasi_instansi').value = data.alumni.lokasi_instansi || '';
        document.getElementById('kategori_profesi').value = data.alumni.kategori_profesi || '';
        document.getElementById('profesi').value = data.alumni.profesi || '';
        document.getElementById('tanggal_lulus').value = data.alumni.tanggal_lulus || '';
        document.getElementById('tanggal_pertama_kerja').value = data.alumni.tanggal_pertama_kerja || '';
        document.getElementById('is_infokom').value = data.alumni.is_infokom ? '1' : '0';

        // Isi dropdown program studi
        prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
        
        data.programStudi.forEach(program => {
            const option = document.createElement('option');
            option.value = program.prodi_id;
            option.textContent = program.nama_prodi; // Pastikan menggunakan nama_prodi
            
            // Set selected jika prodi_id sama dengan alumni
            if (program.prodi_id == data.alumni.prodi_id) {
                option.selected = true;
            }
            
            prodiSelect.appendChild(option);
        });

        document.getElementById('editForm').action = `/alumni/${id}`;
        document.getElementById('editModal').style.display = 'flex';
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal memuat data alumni');
    });
}
 // Fungsi untuk menutup modal edit
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }


    // Load program studi saat modal dibuka
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/program-studi')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('prodi');
                select.innerHTML = '<option value="">Pilih Program Studi</option>';
                
                data.forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi.prodi_id;
                    option.textContent = prodi.nama_prodi;
                    select.appendChild(option);
                });
            });
    });
</script>