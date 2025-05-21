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


  </form>
