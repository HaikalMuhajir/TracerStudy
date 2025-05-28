document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            year: 'numeric', month: 'long', day: 'numeric'
        });
    }

    function showAlumniData(alumni) {
        const fields = {
            showNama: alumni.nama,
            showNIM: alumni.nim,
            showProdi: alumni.program_studi?.nama_prodi,
            showEmail: alumni.email,
            showNoHP: alumni.no_hp,
            showJenisInstansi: alumni.jenis_instansi,
            showNamaInstansi: alumni.nama_instansi,
            showSkalaInstansi: alumni.skala_instansi,
            showLokasiInstansi: alumni.lokasi_instansi,
            showKategoriProfesi: alumni.kategori_profesi,
            showPekerjaan: alumni.profesi,
            showTanggalLulus: formatDate(alumni.tanggal_lulus),
            showTanggalKerja: formatDate(alumni.tanggal_pertama_kerja),
            showToken: alumni.token
        };

        for (const [id, value] of Object.entries(fields)) {
            const el = document.getElementById(id);
            if (el) el.textContent = value || '-';
        }
    }

    window.openShowModal = (id) => {
        document.querySelectorAll('#showModal [id^="show"]').forEach(el => el.textContent = 'Loading...');
        fetch(`/alumni/${id}/show`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) throw new Error(data.message);
            showAlumniData(data.data);
            document.getElementById('showModal').classList.remove('hidden');
        })
        .catch(err => {
            Swal.fire('Gagal', err.message || 'Terjadi kesalahan', 'error');
            document.getElementById('showModal').classList.add('hidden');
        });
    };

    window.openEditModal = (id) => {
        fetch(`/alumni/${id}/edit`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(res => res.json())
        .then(data => {
            const alumni = data.alumni;
            const prodiSelect = document.getElementById('prodi');
            if (prodiSelect) {
                prodiSelect.innerHTML = '';
                data.programStudi.forEach(p => {
                    const opt = new Option(p.nama_prodi || p.nama, p.prodi_id, false, p.prodi_id == alumni.prodi_id);
                    prodiSelect.add(opt);
                });
            }

            [
                'nama', 'nim', 'email', 'no_hp',
                'jenis_instansi', 'nama_instansi', 'skala_instansi', 'lokasi_instansi',
                'kategori_profesi', 'profesi', 'tanggal_lulus', 'tanggal_pertama_kerja', 'token'
            ].forEach(field => {
                const el = document.getElementById(field);
                if (el) el.value = alumni[field] || '';
            });

            const editForm = document.getElementById('editForm');
            if (editForm) {
                editForm.action = `/alumni/${id}`;
                document.getElementById('editModal').classList.remove('hidden');
            }
        })
        .catch(err => {
            Swal.fire('Error', err.message || 'Gagal memuat data', 'error');
        });
    };

    window.closeModal = (id) => document.getElementById(id).classList.add('hidden');

    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Menyimpan...';

            const data = Object.fromEntries(new FormData(this).entries());
            data._method = 'PUT';

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Berhasil', 'Data berhasil diperbarui', 'success').then(() => {
                        closeModal('editModal');
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Gagal menyimpan data');
                }
            })
            .catch(err => {
                Swal.fire('Error', err.message, 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Simpan';
            });
        });
    }
});

