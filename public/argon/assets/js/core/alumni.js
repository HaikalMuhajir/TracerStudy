// Fungsi untuk menampilkan Detail Alumni menggunakan AJAX
function showDetail(alumni_id) {
    console.log("Detail button clicked for alumni_id: " + alumni_id);
    fetch(`/alumni/detail/${alumni_id}`)
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
function editData(alumni_id) {
    console.log("Edit button clicked for alumni_id: " + alumni_id);
    fetch(`/alumni/edit/${alumni_id}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);  // Memeriksa data yang diterima
            
            // Populate the edit modal fields with the data
            $('#editModal').find('#alumni_id').val(data.alumni.alumni_id);
            $('#editModal').find('#nim').val(data.alumni.nim);
            $('#editModal').find('#no_hp').val(data.alumni.no_hp);
            $('#editModal').find('#jenis_instansi').val(data.alumni.jenis_instansi);
            $('#editModal').find('#nama_instansi').val(data.alumni.nama_instansi);
            $('#editModal').find('#skala_instansi').val(data.alumni.skala_instansi);
            $('#editModal').find('#lokasi_instansi').val(data.alumni.lokasi_instansi);
            $('#editModal').find('#kategori_profesi').val(data.alumni.kategori_profesi);
            $('#editModal').find('#profesi').val(data.alumni.profesi);
            $('#editModal').find('#tanggal_lulus').val(data.alumni.tanggal_lulus);
            $('#editModal').find('#tahun_lulus').val(data.alumni.tahun_lulus);
            $('#editModal').find('#tanggal_pertama_kerja').val(data.alumni.tanggal_pertama_kerja);
            $('#editModal').find('#nama').val(data.alumni.user.name);  // Nama alumni

            // Populate the program studi dropdown
            const programStudiSelect = $('#editModal').find('#program_studi');
            programStudiSelect.empty();  // Clear existing options
            programStudiSelect.append('<option value="">Select Program Studi</option>');  // Default option
            data.programStudi.forEach(function(prodi) {
                programStudiSelect.append('<option value="' + prodi.prodi_id + '">' + prodi.nama_prodi + '</option>');
            });

            // Select the current program studi
            programStudiSelect.val(data.alumni.prodi_id);  // Pre-select the current prodi

            // Show the edit modal
            $('#editModal').modal('show');
        })
        .catch(error => console.error('Error fetching alumni data for edit:', error));
}

$('#editForm').on('submit', function(e) {
    e.preventDefault();
    
    const alumni_id = $('#alumni_id').val();
    const form = document.getElementById('editForm');
    const formData = new FormData(form);
    
    // Tambahkan method override
    formData.append('_method', 'PUT');
    
    $.ajax({
        url: `/alumni/update/${alumni_id}`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            toastr.success('Data alumni berhasil diperbarui!');
            $('#editModal').modal('hide');
            location.reload();
        },
        error: function(error) {
            toastr.error('Gagal memperbarui data alumni.');
            console.error('Error:', error.responseJSON);
        }
    });
});

let alumniIdToDelete = null; // Variabel untuk menyimpan ID alumni yang akan dihapus

// Fungsi untuk menunjukkan modal konfirmasi
function showDeleteConfirmationModal(alumni_id) {
    alumniIdToDelete = alumni_id; // Simpan ID alumni
    $('#deleteConfirmationModal').modal('show'); // Tampilkan modal
}

// Fungsi untuk menghapus data setelah konfirmasi
document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
    const deleteBtn = document.querySelector(`button[data-id="${alumniIdToDelete}"]`);
    const originalText = deleteBtn.innerHTML;
    deleteBtn.disabled = true;
    deleteBtn.innerHTML = 'Menghapus...';

    try {
        const response = await axios.delete(`/alumni/delete/${alumniIdToDelete}`);

        toastr.success(response.data.message || 'Data berhasil dihapus');

        // Hapus baris dari tabel
        const row = document.querySelector(`tr[data-id="${alumniIdToDelete}"]`);
        if (row) row.remove();

        // Refresh halaman setelah menghapus data
        location.reload();

    } catch (error) {
        const errorMsg = error.response?.data?.message ||
                        error.message ||
                        'Gagal menghapus data';
        toastr.error(errorMsg);
        console.error('Delete error:', error);
    } finally {
        deleteBtn.disabled = false;
        deleteBtn.innerHTML = originalText;
        $('#deleteConfirmationModal').modal('hide'); // Tutup modal
    }
});
