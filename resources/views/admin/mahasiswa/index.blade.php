@extends('layouts.template')

@section('content')
<div class="text-white text-center">
    <h1 class="judul-halaman text-white">{{ $pageTitle }}</h1>
    <p class="subjudul-halaman">Ini adalah halaman data mahasiswa.</p>
</div>

<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>{{ $pageTitle }}</h6>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIM</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Prodi</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tahun Pertama</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lulus</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($mahasiswas as $mahasiswa)
                  <tr>
                    <td>{{ $mahasiswa->user->name }}</td> <!-- Menampilkan nama dari relasi user -->
                    <td>{{ $mahasiswa->nim }}</td>
                    <td>{{ $mahasiswa->programStudi->nama_prodi }}</td> <!-- Menampilkan nama prodi dari relasi programStudi -->
                    <td>{{ $mahasiswa->tanggal_pertama_kerja }}</td> <!-- Menampilkan tahun lulus -->
                    <td>{{ $mahasiswa->tanggal_lulus }}</td> <!-- Menampilkan tanggal lulus -->
                    <td class="align-middle text-center text-sm" id="status-cell-{{ $mahasiswa->alumni_id }}">
                      @if($mahasiswa->status == 'Belum Mengisi')
                          <span class="badge bg-secondary">Belum Mengisi</span>
                      @elseif($mahasiswa->status == 'Ditinjau')
                          <div class="dropdown">
                              <button class="btn btn-warning dropdown-toggle" type="button" 
                                      data-bs-toggle="dropdown" aria-expanded="false">
                                  Ditinjau
                              </button>
                              <ul class="dropdown-menu">
                                  <li>
                                      <button type="button" class="dropdown-item text-success update-status"
                                              data-id="{{ $mahasiswa->alumni_id }}"
                                              data-status="Sudah Mengisi">
                                          <i class="fas fa-check me-2"></i>Setujui
                                      </button>
                                  </li>
                                  <li>
                                      <button type="button" class="dropdown-item text-danger update-status"
                                              data-id="{{ $mahasiswa->alumni_id }}"
                                              data-status="Ditolak">
                                          <i class="fas fa-times me-2"></i>Tolak
                                      </button>
                                  </li>
                              </ul>
                          </div>
                      @elseif($mahasiswa->status == 'Sudah Mengisi')
                          <span class="badge bg-success">Sudah Mengisi</span>
                      @else
                          <span class="badge bg-danger">Ditolak</span>
                      @endif
                  </td>
                    <td class="align-middle text-center">
                      <div class="btn-group">
                        <button class="btn btn-primary btn-sm action-btn" onclick="showDetail({{ $mahasiswa->alumni_id }})">Detail</button>
                        <button class="btn btn-warning btn-sm action-btn" onclick="editData({{ $mahasiswa->alumni_id }})">Edit</button>
                        <button class="btn btn-danger btn-sm action-btn" onclick="deleteData({{ $mahasiswa->alumni_id }}, event)">Hapus</button>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <div class="mb-3">
                  <form method="GET" action="{{ url('/mahasiswa') }}">
                      <input type="text" id="searchInput" name="search" class="form-control" placeholder="Cari berdasarkan Nama atau NIM" value="{{ request('search') }}" onkeyup="this.form.submit()">
                  </form>
              </div> 
              </table>           
            </div>
              <!-- Display Pagination -->
              <div class="d-flex justify-content-center">
                {{ $mahasiswas->links('pagination::bootstrap-4') }}  <!-- Menampilkan kontrol pagination -->
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Modal for Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="detailModalLabel">Detail Mahasiswa</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div id="detailContent"></div> <!-- Data will be injected here via AJAX -->
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>

<!-- Modal for Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Data Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" id="alumni_id" name="alumni_id">

          <div class="form-group">
            <label for="nama">Nama{{ old('$mahasiswa->user->name')}}</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
          </div>

          <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" required>
          </div>

          <div class="form-group">
            <label for="no_hp">No HP</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" required>
          </div>

          <div class="form-group">
            <label for="jenis_instansi">Jenis Instansi</label>
            <input type="text" class="form-control" id="jenis_instansi" name="jenis_instansi" required>
          </div>

          <div class="form-group">
            <label for="nama_instansi">Nama Instansi</label>
            <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" required>
          </div>

          <div class="form-group">
            <label for="skala_instansi">Skala Instansi</label>
            <input type="text" class="form-control" id="skala_instansi" name="skala_instansi" required>
          </div>

          <div class="form-group">
            <label for="lokasi_instansi">Lokasi Instansi</label>
            <input type="text" class="form-control" id="lokasi_instansi" name="lokasi_instansi" required>
          </div>

          <div class="form-group">
            <label for="kategori_profesi">Kategori Profesi</label>
            <input type="text" class="form-control" id="kategori_profesi" name="kategori_profesi" required>
          </div>

          <div class="form-group">
            <label for="profesi">Profesi</label>
            <input type="text" class="form-control" id="profesi" name="profesi" required>
          </div>

          <div class="form-group">
            <label for="tanggal_lulus">Tanggal Lulus</label>
            <input type="date" class="form-control" id="tanggal_lulus" name="tanggal_lulus" required>
          </div>

          <div class="form-group">
            <label for="tahun_lulus">Tahun Lulus</label>
            <input type="number" class="form-control" id="tahun_lulus" name="tahun_lulus" required>
          </div>

          <div class="form-group">
            <label for="tanggal_pertama_kerja">Tanggal Pertama Kerja</label>
            <input type="date" class="form-control" id="tanggal_pertama_kerja" name="tanggal_pertama_kerja" required>
          </div>

          <div class="form-group">
            <label for="program_studi">Program Studi</label>
            <select id="program_studi" name="program_studi" class="form-control" required>
                <option value="">Select Program Studi</option>
                <!-- Program Studi options will be populated dynamically via JavaScript -->
            </select>
        </div>
        

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
        </form>
      </div>
    </div>
  </div>
</div>

  <script>
// Fungsi untuk menampilkan Detail Mahasiswa menggunakan AJAX
  function showDetail(alumni_id) {
      console.log("Detail button clicked for alumni_id: " + alumni_id);
      fetch(`/mahasiswa/detail/${alumni_id}`)
          .then(response => response.json())
          .then(data => {
            console.log(data);  // Memeriksa data yang diterima
              document.getElementById('detailContent').innerHTML = `
                  <p><strong>Nama:</strong> ${data.user.name}</p>
                  <p><strong>NIM:</strong> ${data.nim}</p>
                  <p><strong>No HP:</strong> ${data.no_hp}</p>
                  <p><strong>Jenis Instansi:</strong> ${data.jenis_instansi}</p>
                  <p><strong>Nama Instansi:</strong> ${data.nama_instansi}</p>
                  <p><strong>Skala Instansi:</strong> ${data.skala_instansi}</p>
                  <p><strong>Lokasi Instansi:</strong> ${data.lokasi_instansi}</p>
                  <p><strong>Kategori Profesi:</strong> ${data.kategori_profesi}</p>
                  <p><strong>Profesi:</strong> ${data.profesi}</p>
                  <p><strong>Tanggal Lulus:</strong> ${data.tanggal_lulus}</p>
                  <p><strong>Tahun Lulus:</strong> ${data.tahun_lulus}</p>
                  <p><strong>Tanggal Pertama Kerja:</strong> ${data.tanggal_pertama_kerja}</p>
                  <p><strong>Program Studi:</strong> ${data.program_studi.nama_prodi}</p>
              `;
              $('#detailModal').modal('show');  // Menampilkan modal
          })
          .catch(error => console.error('Error fetching details:', error));
  }


      // Edit Data - Placeholder function
    // Function to handle edit action
    function editData(alumni_id) {
    console.log("Edit button clicked for alumni_id: " + alumni_id);
    fetch(`/mahasiswa/edit/${alumni_id}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);  // Memeriksa data yang diterima

            // Populate the edit modal fields with the data
            $('#editModal').find('#alumni_id').val(data.mahasiswa.alumni_id);
            $('#editModal').find('#nim').val(data.mahasiswa.nim);
            $('#editModal').find('#no_hp').val(data.mahasiswa.no_hp);
            $('#editModal').find('#jenis_instansi').val(data.mahasiswa.jenis_instansi);
            $('#editModal').find('#nama_instansi').val(data.mahasiswa.nama_instansi);
            $('#editModal').find('#skala_instansi').val(data.mahasiswa.skala_instansi);
            $('#editModal').find('#lokasi_instansi').val(data.mahasiswa.lokasi_instansi);
            $('#editModal').find('#kategori_profesi').val(data.mahasiswa.kategori_profesi);
            $('#editModal').find('#profesi').val(data.mahasiswa.profesi);
            $('#editModal').find('#tanggal_lulus').val(data.mahasiswa.tanggal_lulus);
            $('#editModal').find('#tahun_lulus').val(data.mahasiswa.tahun_lulus);
            $('#editModal').find('#tanggal_pertama_kerja').val(data.mahasiswa.tanggal_pertama_kerja);
            $('#editModal').find('#nama').val(data.mahasiswa.user.name);  // Nama alumni

            // Populate the program studi dropdown
            const programStudiSelect = $('#editModal').find('#program_studi');
            programStudiSelect.empty();  // Clear existing options
            programStudiSelect.append('<option value="">Select Program Studi</option>');  // Default option
            data.programStudi.forEach(function(prodi) {
                programStudiSelect.append('<option value="' + prodi.prodi_id + '">' + prodi.nama_prodi + '</option>');
            });

            // Select the current program studi
            programStudiSelect.val(data.mahasiswa.prodi_id);  // Pre-select the current prodi

            // Show the edit modal
            $('#editModal').modal('show');
        })
        .catch(error => console.error('Error fetching student data for edit:', error));
}

$('#editForm').on('submit', function(e) {
    e.preventDefault();
    
    const alumni_id = $('#alumni_id').val();
    const form = document.getElementById('editForm');
    const formData = new FormData(form);
    
    // Tambahkan method override
    formData.append('_method', 'PUT');
    
    $.ajax({
        url: `/mahasiswa/update/${alumni_id}`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            toastr.success('Data mahasiswa berhasil diperbarui!');
            $('#editModal').modal('hide');
            location.reload();
        },
        error: function(error) {
            toastr.error('Gagal memperbarui data mahasiswa.');
            console.error('Error:', error.responseJSON);
        }
    });
});

 
async function deleteData(alumni_id, event) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        const deleteBtn = event.target;
        const originalText = deleteBtn.innerHTML;
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = 'Menghapus...';

        try {
            const response = await axios.delete(`/mahasiswa/delete/${alumni_id}`);
            
            toastr.success(response.data.message || 'Data berhasil dihapus');
            
            // Hapus baris dari tabel
            const row = document.querySelector(`tr[data-id="${alumni_id}"]`);
            if (row) row.remove();
            
        } catch (error) {
            const errorMsg = error.response?.data?.message || 
                          error.message || 
                          'Gagal menghapus data';
            toastr.error(errorMsg);
            console.error('Delete error:', error);
        } finally {
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = originalText;
        }
    }
}
  </script>

  <style>
    /* Button Styles for Detail, Edit, and Delete */
    .btn-primary {
      background-color: #007bff; /* Blue for Detail */
    }

    .btn-warning {
      background-color: #ffc107; /* Yellow for Edit */
    }

    .btn-danger {
      background-color: #dc3545; /* Red for Delete */
    }

    /* Button Styles for "Sudah Mengisi" and "Belum Mengisi" */
    .status-toggle {
      font-weight: bold;
      color: white;
      border-radius: 50px;
      padding: 5px 15px;
      text-align: center;
      width: 150px;
    }

    /* Style for "Sudah Mengisi" - Green color */
    .btn-success {
      background-color: #28a745; /* Green for Sudah Mengisi */
    }

    /* Style for "Belum Mengisi" - Gray color */
    .btn-secondary {
      background-color: #6c757d; /* Gray for Belum Mengisi */
    }

    /* Adjust spacing and size for action buttons */
    .btn-group {
      display: flex;
      gap: 15px; /* Add spacing between action buttons */
    }

    .action-btn {
      font-weight: bold;
      color: white;
      padding: 8px 25px; /* Add more padding for better size */
      border-radius: 50px;
    }

    /* Adjust the card body padding */
    .card-body {
      padding: 1.5rem !important; /* Add padding to card body for better spacing */
    }
  </style>
@endsection
