<form method="POST" action="{{ url('/form-alumni/' . $alumni->token) }}">
    @csrf
    <label>Nama: {{ $alumni->nama }}</label><br>

    <label>Jenis Instansi:</label>
    <input type="text" name="jenis_instansi" required><br>

    <label>Nama Instansi:</label>
    <input type="text" name="nama_instansi" required><br>

    <label>Skala Instansi:</label>
    <input type="text" name="skala_instansi" required><br>

    <label>Lokasi Instansi:</label>
    <input type="text" name="lokasi_instansi" required><br>

    <label>Kategori Profesi:</label>
    <input type="text" name="kategori_profesi" required><br>

    <label>Profesi:</label>
    <input type="text" name="profesi" required><br>

    <label>Tanggal Pertama Kerja:</label>
    <input type="date" name="tanggal_pertama_kerja"><br>

    <h4>Data Atasan (Opsional)</h4>
    <label>Nama Atasan</label>
    <input type="text" name="nama_atasan">

    <label>Jabatan Atasan</label>
    <input type="text" name="jabatan_atasan">

    <label>Email Atasan</label>
    <input type="email" name="email_atasan">

    <label>No HP Atasan</label>
    <input type="text" name="no_hp_atasan">


    <button type="submit">Kirim</button>
</form>
