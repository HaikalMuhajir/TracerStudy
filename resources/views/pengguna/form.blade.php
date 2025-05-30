<form method="POST" action="{{ url('/form-pengguna/' . $pengguna->token) }}">
    @csrf

    <label for="tahun_kerja">Tahun Kerja</label>
    <select id="tahun_kerja" name="tahun_kerja" required>
        <option value="" disabled selected>-- Pilih Tahun --</option>
        @foreach($tahunKerjaList as $tahun)
            <option value="{{ $tahun }}" {{ old('tahun_kerja') == $tahun ? 'selected' : '' }}>
                {{ $tahun }}
            </option>
        @endforeach
    </select>
    @error('tahun_kerja')
        <div style="color:red;">{{ $message }}</div>
    @enderror

    @php
    $aspek = [
        'kerjasama_tim' => 'Kerjasama Tim',
        'keahlian_ti' => 'Keahlian TI',
        'bahasa_asing' => 'Bahasa Asing',
        'komunikasi' => 'Komunikasi',
        'pengembangan_diri' => 'Pengembangan Diri',
        'kepemimpinan' => 'Kepemimpinan',
        'etos_kerja' => 'Etos Kerja',
    ];
    @endphp

    @foreach ($aspek as $field => $label)
        <label for="{{ $field }}">{{ $label }} (1-5)</label>
        <input type="number" id="{{ $field }}" name="{{ $field }}" min="1" max="5" required value="{{ old($field) }}">
        @error($field)
            <div style="color:red;">{{ $message }}</div>
        @enderror
    @endforeach

    <label for="kompetensi_kurang">Kompetensi Kurang (opsional)</label>
    <textarea id="kompetensi_kurang" name="kompetensi_kurang">{{ old('kompetensi_kurang') }}</textarea>

    <label for="saran_kurikulum">Saran Kurikulum (opsional)</label>
    <textarea id="saran_kurikulum" name="saran_kurikulum">{{ old('saran_kurikulum') }}</textarea>

    <button type="submit">Simpan</button>
</form>
