@extends('layouts.template')

@section('content')
<div class="text-white text-center">
    <h1 class="judul-halaman text-white">Data Mahasiswa</h1>
    <p class="subjudul-halaman">Ini adalah halaman data mahasiswa.</p>
</div>
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Data Mahasiswa</h6>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIM</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Prodi</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tahun</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lulus</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>John Michael</td>
                    <td>123456</td>
                    <td>Informatika</td>
                    <td>2020</td>
                    <td>2024</td>
                    <td class="align-middle text-center text-sm">
                      <button class="btn status-toggle btn-success" data-status="sudah-mengisi">Sudah Mengisi</button>
                    </td>
                    <td class="align-middle text-center">
                      <!-- Aksi buttons -->
                      <div class="btn-group">
                        <button class="btn btn-primary btn-sm action-btn" onclick="showDetail(123456)">Detail</button>
                        <button class="btn btn-warning btn-sm action-btn" onclick="editData(123456)">Edit</button>
                        <button class="btn btn-danger btn-sm action-btn" onclick="deleteData(123456)">Hapus</button>
                      </div>
                    </td>
                  </tr>
                  <!-- Add more rows as needed -->
                </tbody>
              </table>
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
          <div id="detailContent"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Toggle status between "Sudah Mengisi" and "Belum Mengisi"
    document.querySelectorAll('.status-toggle').forEach(button => {
      button.addEventListener('click', function() {
        const currentStatus = this.getAttribute('data-status');
        
        if (currentStatus === 'sudah-mengisi') {
          this.classList.remove('btn-success');
          this.classList.add('btn-secondary');
          this.textContent = 'Belum Mengisi';
          this.setAttribute('data-status', 'belum-mengisi');
        } else {
          this.classList.remove('btn-secondary');
          this.classList.add('btn-success');
          this.textContent = 'Sudah Mengisi';
          this.setAttribute('data-status', 'sudah-mengisi');
        }
        
        // You can add additional logic here to update status in the backend if needed
      });
    });

    // Show Detail - AJAX Request for Detail
    function showDetail(studentId) {
      fetch(`/mahasiswa/detail/${studentId}`)
        .then(response => response.json())
        .then(data => {
          document.getElementById('detailContent').innerHTML = ` 
            <p><strong>Nama:</strong> ${data.nama}</p>
            <p><strong>NIM:</strong> ${data.nim}</p>
            <p><strong>Prodi:</strong> ${data.prodi}</p>
            <p><strong>Tahun Lulus:</strong> ${data.tahun_lulus}</p>
          `;
          $('#detailModal').modal('show');
        })
        .catch(error => console.error('Error fetching details:', error));
    }

    // Edit Data - Placeholder function
    function editData(studentId) {
      alert('Edit functionality for ' + studentId);
    }

    // Delete Data - Placeholder function
    function deleteData(studentId) {
      if (confirm('Are you sure you want to delete this student?')) {
        fetch(`/mahasiswa/delete/${studentId}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            toastr.success('Mahasiswa berhasil dihapus.');
            location.reload();
          } else {
            toastr.error('Gagal menghapus mahasiswa.');
          }
        })
        .catch(error => console.error('Error deleting student:', error));
      }
    }

    // Display Toastr success notification after an action (Example)
    function showSuccessNotification(message) {
      toastr.success(message, 'Sukses!');
    }

    // Display Toastr error notification after an action (Example)
    function showErrorNotification(message) {
      toastr.error(message, 'Error!');
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
