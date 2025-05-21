<div class="mb-3">
    <form method="GET" action="{{ url('/alumni') }}">
        <input type="text" id="searchInput" name="search" class="form-control" placeholder="Cari berdasarkan Nama atau NIM" value="{{ request('search') }}" onkeyup="this.form.submit()">
    </form>
  </div>
<div class="table-responsive p-0">
    <table class="table align-items-center mb-0">
      <thead>
        <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIM</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Prodi</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tahun Pertama</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lulus</th>
          {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th> --}}
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($alumnis as $alumni)
        <tr>
          <td>{{ $alumni->user->name }}</td> 
          <td>{{ $alumni->nim }}</td>
          <td>{{ $alumni->programStudi->nama_prodi }}</td>
          <td>{{ $alumni->tanggal_pertama_kerja }}</td>
          <td>{{ $alumni->tanggal_lulus }}</td>
          {{-- <td class="align-middle text-center text-sm" id="status-cell-{{ $alumni->alumni_id }}">
            @include('admin.alumni.alumni-status', ['alumni' => $alumni])  <!-- Menampilkan status -->
          </td> --}}
          <td class="align-middle text-center">
            <div class="btn-group">
              <button class="btn btn-primary btn-sm action-btn" onclick="showDetail({{ $alumni->alumni_id }})">Detail</button>
              <button class="btn btn-warning btn-sm action-btn" onclick="editData({{ $alumni->alumni_id }})">Edit</button>
              <button class="btn btn-danger btn-sm action-btn" onclick="showDeleteConfirmationModal({{ $alumni->alumni_id }})" data-id="{{ $alumni->alumni_id }}">Hapus</button>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>           
  </div>
  <div class="d-flex justify-content-center">
    {{ $alumnis->links('pagination::bootstrap-4') }}  
  </div>
  