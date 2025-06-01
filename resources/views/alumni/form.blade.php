<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulir Tracer Study</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/polinema.png') }}" type="image/x-icon" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", Arial, sans-serif;
            background-color: #f9fafb;
            color: #111827;
        }

        .formbold-main-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 16px;
            min-height: 100vh;
        }

        input[type="date"].formbold-form-input {
            appearance: auto;
            -webkit-appearance: textfield;
            -moz-appearance: textfield;
            background-color: #fff;
            cursor: pointer;
            font-family: Arial, sans-serif;
            /* fallback font */
        }

        .formbold-form-wrapper {
            background: white;
            max-width: 1200px;
            width: 100%;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .formbold-form-label {
            display: block;
            font-weight: 500;
            font-size: 16px;
            margin-bottom: 8px;
            color: #374151;
        }

        .formbold-form-label-2 {
            font-weight: 700;
            font-size: 22px;
            margin-bottom: 24px;
            color: #1e3a8a;
        }

        .formbold-form-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 16px;
            margin-bottom: 24px;
        }

        .formbold-form-input:focus {
            border-color: #6366f1;
            box-shadow: 0px 0px 5px rgba(99, 102, 241, 0.3);
            outline: none;
        }

        .formbold-btn {
            font-size: 16px;
            border-radius: 6px;
            padding: 14px 32px;
            border: none;
            font-weight: 600;
            background-color: #6366f1;
            color: white;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .formbold-btn:hover {
            background-color: #4f46e5;
        }

        .form-row {
            display: flex;
            flex-direction: column;
            width: 48%;
            margin-bottom: 24px;
        }

        .form-row:nth-child(odd) {
            margin-right: 4%;
        }

        .form-section {
            margin-bottom: 32px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 24px;
        }

        .form-section:last-of-type {
            border-bottom: none;
        }

        @media (min-width: 769px) {
            .form-section {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }
        }

        @media (max-width: 768px) {
            .form-row {
                width: 100%;
                margin-right: 0;
            }
        }

        .text-center {
            text-align: center;
        }

        .mb-8 {
            margin-bottom: 32px;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .mt-2 {
            margin-top: 8px;
        }

        .text-blue-900 {
            color: #1e3a8a;
        }

        .text-gray-700 {
            color: #374151;
        }

        .text-green-800 {
            color: #166534;
        }

        .text-sm {
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <div class="formbold-main-wrapper">
        <div class="formbold-form-wrapper">
            <div class="text-center mb-8">
                <img src="{{ asset('assets/img/logo/polinema.png') }}" alt="Logo" class=" mx-auto mb-2"
                    style="height: 8rem" />
                <h1 class="text-7xl font-semibold text-blue-900">Formulir Tracer Study Alumni</h1>
                <p class="mt-2 text-lg font-medium text-gray-700">Halo, {{ $alumni->nama }}</p>
            </div>

            <form method="POST" action="{{ url('/form-alumni/' . $alumni->token) }}">
                @csrf

                <div class="form-section" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: center;">
                    <div style="flex: 1 1 150px; min-width: 150px;">
                        <label class="formbold-form-label" for="nama_instansi">Nama Instansi</label>
                        <input type="text" id="nama_instansi" name="nama_instansi" required
                            class="formbold-form-input" />
                    </div>
                    <div style="flex: 1 1 150px; min-width: 150px;">
                        <label class="formbold-form-label" for="lokasi_instansi">Lokasi Instansi</label>
                        <input type="text" id="lokasi_instansi" name="lokasi_instansi" required
                            class="formbold-form-input" />
                    </div>

                    <!-- Baris 4 input dalam satu baris -->
                    <div style="display: flex; flex-wrap: nowrap; gap: 16px; width: 100%;">
                        <div style="flex: 1 1 0; min-width: 150px;">
                            <label class="formbold-form-label" for="skala_instansi">Skala Instansi</label>
                            <input type="text" id="skala_instansi" name="skala_instansi" required
                                class="formbold-form-input" />
                        </div>
                        <div style="flex: 1 1 0; min-width: 150px;">
                            <label class="formbold-form-label" for="jenis_instansi">Jenis Instansi</label>
                             <input type="text" id="jenis_instansi" name="jenis_instansi" required
                                class="formbold-form-input" />
                        </div>
                        <div style="flex: 1 1 0; min-width: 150px;">
                            <label class="formbold-form-label" for="kategori_profesi">Kategori Profesi</label>
                            <input type="text" id="kategori_profesi" name="kategori_profesi" required
                                class="formbold-form-input" />
                        </div>
                        <div style="flex: 1 1 0; min-width: 150px;">
                            <label class="formbold-form-label" for="tanggal_pertama_kerja">Tanggal Pertama Kerja</label>
                            <input type="date" id="tanggal_pertama_kerja" name="tanggal_pertama_kerja"
                                class="formbold-form-input" />
                        </div>
                    </div>

                    <div style="flex: 1 1 150px; min-width: 150px;">
                        <label class="formbold-form-label" for="profesi">Profesi</label>
                        <input type="text" id="profesi" name="profesi" required class="formbold-form-input" />
                    </div>
                </div>



                <div class="form-section">
                    <h2 class="formbold-form-label-2 ">Informasi Atasan <span
                            class="text-sm text-gray-500">(Opsional)</span></h2>
                    <div class="form-row">
                    </div>
                    <div class="form-row">
                        <label class="formbold-form-label">Nama Atasan</label>
                        <input type="text" name="nama_atasan" class="formbold-form-input" />
                    </div>

                    <div class="form-row">
                        <label class="formbold-form-label">Jabatan Atasan</label>
                        <input type="text" name="jabatan_atasan" class="formbold-form-input" />
                    </div>

                    <div class="form-row">
                        <label class="formbold-form-label">Email Atasan</label>
                        <input type="email" name="email_atasan" class="formbold-form-input" />
                    </div>

                    <div class="form-row">
                        <label class="formbold-form-label">No HP Atasan</label>
                        <input type="text" name="no_hp_atasan" class="formbold-form-input" />
                    </div>
                </div>

                <div style="clear: both;">
                    <button type="submit" class="formbold-btn">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
