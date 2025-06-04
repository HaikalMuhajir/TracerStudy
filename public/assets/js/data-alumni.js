document.addEventListener("DOMContentLoaded", () => {
    const csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
    )?.content;

    const kategoriSelect = document.getElementById("kategori_profesi");
    const profesiSelect = document.getElementById("profesi");
    const profesiInput = document.getElementById("profesi_lainnya"); // pastikan elemen ini ada di Blade

    const profesiOptions = {
        Infokom: [
            "Developer/Programmer/Software Engineer",
            "IT Support/IT Administrator",
            "Infrastructure Engineer",
            "Digital Marketing Specialist",
            "Graphic Designer/Multimedia Designer",
            "Business Analyst",
            "QA Engineer/Tester",
            "IT Enterpreneur",
            "Trainer/Guru/Dosen (IT)",
            "Mahasiswa",
            "Lainnya",
        ],
        "Non Infokom": [
            "Procurement & Operational Team",
            "Wirausahawan (Non IT)",
            "Trainer/Guru/Dosen (Non IT)",
            "Mahasiswa",
            "Lainnya",
        ],
        "Tidak Bekerja": [],
    };

    function updateProfesiOptions(selectedKategori, selectedProfesi = null) {
        const options = profesiOptions[selectedKategori] || [];
        profesiSelect.innerHTML =
            '<option value="" disabled selected>Pilih profesi</option>';
        options.forEach((item) => {
            const option = document.createElement("option");
            option.value = item;
            option.textContent = item;
            if (item === selectedProfesi) option.selected = true;
            profesiSelect.appendChild(option);
        });
        // Reset profesi input jika opsi berubah
        if (profesiInput) {
            profesiInput.classList.add("hidden");
            profesiInput.removeAttribute("required");
            profesiInput.value = "";
        }
    }

    if (kategoriSelect && profesiSelect) {
        kategoriSelect.addEventListener("change", function () {
            updateProfesiOptions(this.value);
        });

        profesiSelect.addEventListener("change", function () {
            if (this.value.includes("Lainnya")) {
                profesiInput.classList.remove("hidden");
                profesiInput.setAttribute("required", "required");
            } else {
                profesiInput.classList.add("hidden");
                profesiInput.removeAttribute("required");
                profesiInput.value = "";
            }
        });

        // Initial load
        if (kategoriSelect.value) {
            updateProfesiOptions(kategoriSelect.value, profesiSelect.value);
        }
    }

    function formatDate(dateString) {
        if (!dateString) return "-";
        const date = new Date(dateString);
        return date.toLocaleDateString("id-ID", {
            year: "numeric",
            month: "long",
            day: "numeric",
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
            showToken: alumni.token,
        };

        for (const [id, value] of Object.entries(fields)) {
            const el = document.getElementById(id);
            if (el) el.textContent = value || "-";
        }
    }

    window.openShowModal = (id) => {
        document
            .querySelectorAll('#showModal [id^="show"]')
            .forEach((el) => (el.textContent = "Loading..."));
        fetch(`/alumni/${id}/show`, {
            headers: {
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": csrfToken,
            },
        })
            .then((res) => res.json())
            .then((data) => {
                if (!data.success) throw new Error(data.message);
                showAlumniData(data.data);
                document.getElementById("showModal").classList.remove("hidden");
            })
            .catch((err) => {
                Swal.fire("Gagal", err.message || "Terjadi kesalahan", "error");
                document.getElementById("showModal").classList.add("hidden");
            });
    };

    window.openEditModal = (id) => {
        fetch(`/alumni/${id}/edit`, {
            headers: {
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": csrfToken,
            },
        })
            .then((res) => res.json())
            .then((data) => {
                const alumni = data.alumni;
                const prodiSelect = document.getElementById("prodi");
                if (prodiSelect) {
                    prodiSelect.innerHTML = "";
                    data.programStudi.forEach((p) => {
                        const opt = new Option(
                            p.nama_prodi || p.nama,
                            p.prodi_id,
                            false,
                            p.prodi_id == alumni.prodi_id
                        );
                        prodiSelect.add(opt);
                    });
                }

                [
                    "nama",
                    "nim",
                    "email",
                    "no_hp",
                    "jenis_instansi",
                    "nama_instansi",
                    "skala_instansi",
                    "lokasi_instansi",
                    "kategori_profesi",
                    "profesi",
                    "tanggal_lulus",
                    "tanggal_pertama_kerja",
                    "token",
                ].forEach((field) => {
                    const el = document.getElementById(field);
                    if (el) el.value = alumni[field] || "";
                });

                const editForm = document.getElementById("editForm");
                if (editForm) {
                    editForm.action = `/alumni/${id}`;
                    document
                        .getElementById("editModal")
                        .classList.remove("hidden");
                }
            })
            .catch((err) => {
                Swal.fire("Error", err.message || "Gagal memuat data", "error");
            });
    };

    window.closeModal = (id) =>
        document.getElementById(id).classList.add("hidden");

    const editForm = document.getElementById("editForm");
    if (editForm) {
        editForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = "Menyimpan...";

            const data = Object.fromEntries(new FormData(this).entries());
            data._method = "PUT";

            fetch(this.action, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
                body: JSON.stringify(data),
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        Swal.fire(
                            "Berhasil",
                            "Data berhasil diperbarui",
                            "success"
                        ).then(() => {
                            closeModal("editModal");
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message || "Gagal menyimpan data");
                    }
                })
                .catch((err) => {
                    Swal.fire("Error", err.message, "error");
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = "Simpan";
                });
        });
    }
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const table = document.getElementById("alumniTable");
        const rows = table
            .getElementsByTagName("tbody")[0]
            .getElementsByTagName("tr");

        searchInput.addEventListener("keyup", function () {
            const keyword = this.value.toLowerCase();

            for (let i = 0; i < rows.length; i++) {
                let rowText = rows[i].textContent.toLowerCase();
                if (rowText.includes(keyword)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");

    function fetchAlumni(page = 1, search = "") {
        fetch(`?page=${page}&search=${search}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((res) => res.text())
            .then((html) => {
                document.getElementById("alumniTableWrapper").innerHTML = html;
                attachPaginationEvents();
            });
    }

    function attachPaginationEvents() {
        document
            .querySelectorAll("#alumniTableWrapper .pagination a")
            .forEach((link) => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    const page = url.searchParams.get("page");
                    fetchAlumni(page, searchInput.value);
                });
            });
    }

    // Search saat ketik
    searchInput.addEventListener("keyup", function () {
        fetchAlumni(1, this.value);
    });

    attachPaginationEvents(); // initial attach
});

const resetButton = document.getElementById("resetButton");

function fetchAlumni(page = 1, search = "") {
    const wrapper = document.getElementById("alumniTableWrapper");
    wrapper.innerHTML = "<p class='text-center py-4'>Loading...</p>"; // loading text

    fetch(`?page=${page}&search=${search}`, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then((res) => res.text())
        .then((html) => {
            wrapper.innerHTML = html;
            attachPaginationEvents(); // panggil ulang event
        });
}

function toggleFields(disable) {
    const fields = [
        "tanggal_pertama_kerja",
        "nama_instansi",
        "lokasi_instansi",
        "skala_instansi",
        "jenis_instansi",
        "profesi",
        "profesi_lainnya",
        "nama_atasan",
        "jabatan_atasan",
        "email_atasan",
        "no_hp_atasan",
    ];

    fields.forEach((id) => {
        const el = document.getElementById(id);
        if (el) {
            if (disable) {
                el.disabled = true;
                el.classList.add(
                    "bg-gray-100",
                    "text-gray-500",
                    "cursor-not-allowed"
                );
                el.removeAttribute("required");
            } else {
                el.disabled = false;
                el.classList.remove(
                    "bg-gray-100",
                    "text-gray-500",
                    "cursor-not-allowed"
                );
                // Tambahkan kembali required hanya untuk field yang memang wajib
                if (
                    [
                        "tanggal_pertama_kerja",
                        "nama_instansi",
                        "lokasi_instansi",
                        "skala_instansi",
                        "jenis_instansi",
                        "profesi",
                    ].includes(id)
                ) {
                    el.setAttribute("required", "required");
                }
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const kategori = document.getElementById("kategori_profesi");
    kategori.addEventListener("change", function () {
        toggleFields(kategori.value === "Tidak Bekerja");
    });

    // Jalankan sekali saat halaman pertama dimuat
    toggleFields(kategori.value === "Tidak Bekerja");
});

document.getElementById("profesi").addEventListener("change", function () {
    const selected = this.value;
    const inputLainnya = document.getElementById("profesi_lainnya");

    if (selected === "Lainnya") {
        inputLainnya.classList.remove("hidden");
        inputLainnya.setAttribute("required", "required");
    } else {
        inputLainnya.classList.add("hidden");
        inputLainnya.removeAttribute("required");
    }
});
