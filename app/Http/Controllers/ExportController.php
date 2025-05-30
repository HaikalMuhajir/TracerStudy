<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Pengguna;
use App\Models\Performa;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class ExportController extends Controller
{
    /**
     * Fungsi helper untuk menghasilkan file Excel.
     *
     * @param mixed $data Data yang akan diekspor.
     * @param array $headers Header kolom untuk Excel.
     * @param string $filename Nama dasar file (tanpa ekstensi).
     * @param callable $callback Callback untuk mengisi data ke sheet.
     * @param bool $returnPath Jika true, akan mengembalikan path file, bukan BinaryFileResponse.
     * @return BinaryFileResponse|string
     */
    private function generateExcel($data, $headers, $filename, $callback, $returnPath = false)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        foreach ($headers as $index => $header) {
            $column = chr(65 + $index);
            $sheet->setCellValue($column . '1', $header);
            $sheet->getStyle($column . '1')->getFont()->setBold(true);
        }

        // Fill data
        $callback($sheet, $data);

        // Auto size columns
        foreach (range('A', $sheet->getHighestColumn()) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Create file
        $tempFilename = $filename . '_' . now()->format('Ymd_His') . '.xlsx';
        $filenamePath = storage_path('app/public/' . $tempFilename);
        $writer = new Xlsx($spreadsheet);
        $writer->save($filenamePath);

        if ($returnPath) {
            return $filenamePath;
        }

        return response()->download($filenamePath, $tempFilename)->deleteFileAfterSend(true);
    }

    public function exportAll()
{
    // Ambil parameter filter dari request, bisa dari query string atau form
    $prodi = session('filter.prodi');
    $tahunAwal = session('filter.tahun_awal');
    $tahunAkhir = session('filter.tahun_akhir');

    $zip = new ZipArchive();
    $zipFileName = 'alumni_exports_' . now()->format('Ymd_His') . '.zip';
    $zipPath = storage_path('app/public/' . $zipFileName);

    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        $filesToZip = [];

        // Alumni with Atasan (kategori_profesinya tidak null)
        $queryAlumniWithAtasan = Alumni::with(['programStudi', 'performa.pengguna'])
            ->whereNotNull('kategori_profesi');

        // Terapkan filter
        $this->applyBaseFilter($queryAlumniWithAtasan, $prodi, $tahunAwal, $tahunAkhir);

        $filesToZip['Rekap Tracer Studi Lulusan.xlsx'] = $this->generateExcel(
            $queryAlumniWithAtasan->get(),
            ['Nama Alumni', 'NIM', 'Program Studi', 'Email Alumni', 'No HP Alumni', 'Jenis Instansi', 'Nama Instansi', 'Skala Instansi', 'Lokasi Instansi', 'Kategori Profesi', 'Profesi', 'Tanggal Lulus', 'Tanggal Pertama Kerja', 'Nama Atasan', 'Jabatan Atasan', 'No HP Atasan', 'Email Atasan'],
            'alumni_with_atasan',
            function ($sheet, $alumni) {
                foreach ($alumni as $index => $item) {
                    $row = $index + 2;
                    $sheet->setCellValue('A' . $row, $item->nama);
                    $sheet->setCellValue('B' . $row, $item->nim);
                    $sheet->setCellValue('C' . $row, $item->programStudi->nama_prodi ?? '');
                    $sheet->setCellValue('D' . $row, $item->email);
                    $sheet->setCellValue('E' . $row, $item->no_hp);
                    $sheet->setCellValue('F' . $row, $item->jenis_instansi);
                    $sheet->setCellValue('G' . $row, $item->nama_instansi);
                    $sheet->setCellValue('H' . $row, $item->skala_instansi);
                    $sheet->setCellValue('I' . $row, $item->lokasi_instansi);
                    $sheet->setCellValue('J' . $row, $item->kategori_profesi);
                    $sheet->setCellValue('K' . $row, $item->profesi);
                    $sheet->setCellValue('L' . $row, $item->tanggal_lulus);
                    $sheet->setCellValue('M' . $row, $item->tanggal_pertama_kerja);

                    $pengguna = $item->performa->first()->pengguna ?? null;

                    $sheet->setCellValue('N' . $row, $pengguna ? $pengguna->nama : '');
                    $sheet->setCellValue('O' . $row, $pengguna ? $pengguna->jabatan : '');
                    $sheet->setCellValue('P' . $row, $pengguna ? $pengguna->no_hp : '');
                    $sheet->setCellValue('Q' . $row, $pengguna ? $pengguna->email : '');
                }
            },
            true
        );

        // Alumni without Atasan (belum mengisi performa DAN kategori_profesinya null)
        $queryAlumniWithoutAtasan = Alumni::with('programStudi')
            ->whereDoesntHave('performa.pengguna')
            ->whereNull('kategori_profesi');

        // Terapkan filter
        $this->applyBaseFilter($queryAlumniWithoutAtasan, $prodi, $tahunAwal, $tahunAkhir);

        $filesToZip['Rekap Alumni Belum Isi TS.xlsx'] = $this->generateExcel(
            $queryAlumniWithoutAtasan->get(),
            ['Nama Alumni', 'NIM', 'Program Studi', 'Email', 'No HP', 'Jenis Instansi', 'Nama Instansi', 'Skala Instansi', 'Lokasi Instansi', 'Kategori Profesi', 'Profesi', 'Tanggal Lulus', 'Tanggal Pertama Kerja'],
            'alumni_without_atasan',
            function ($sheet, $alumni) {
                foreach ($alumni as $index => $item) {
                    $row = $index + 2;
                    $sheet->setCellValue('A' . $row, $item->nama);
                    $sheet->setCellValue('B' . $row, $item->nim);
                    $sheet->setCellValue('C' . $row, $item->programStudi->nama_prodi ?? '');
                    $sheet->setCellValue('D' . $row, $item->email);
                    $sheet->setCellValue('E' . $row, $item->no_hp);
                    $sheet->setCellValue('F' . $row, $item->jenis_instansi);
                    $sheet->setCellValue('G' . $row, $item->nama_instansi);
                    $sheet->setCellValue('H' . $row, $item->skala_instansi);
                    $sheet->setCellValue('I' . $row, $item->lokasi_instansi);
                    $sheet->setCellValue('J' . $row, $item->kategori_profesi);
                    $sheet->setCellValue('K' . $row, $item->profesi);
                    $sheet->setCellValue('L' . $row, $item->tanggal_lulus);
                    $sheet->setCellValue('M' . $row, $item->tanggal_pertama_kerja);
                }
            },
            true
        );

        // Atasan with Performa
        $queryPenggunaWithPerforma = Pengguna::with(['performa.alumni.programStudi'])
            ->whereHas('performa');

        // Jika filter ingin diterapkan di sini juga, harus menyesuaikan join/relasi dan alias
        // Misal ingin filter alumni terkait di performa:
        if ($prodi || $tahunAwal || $tahunAkhir) {
            $queryPenggunaWithPerforma->whereHas('performa.alumni', function ($q) use ($prodi, $tahunAwal, $tahunAkhir) {
                $this->applyBaseFilter($q, $prodi, $tahunAwal, $tahunAkhir);
            });
        }

        $filesToZip['Rekap Survey Pengguna Lulusan.xlsx'] = $this->generateExcel(
            $queryPenggunaWithPerforma->get(),
            ['Nama Atasan', 'Jabatan', 'No HP', 'Email', 'Nama Alumni', 'NIM Alumni', 'Program Studi Alumni', 'Kerjasama Tim', 'Keahlian TI', 'Bahasa Asing', 'Komunikasi', 'Pengembangan Diri', 'Kepemimpinan', 'Etos Kerja', 'Kompetensi Kurang', 'Saran Kurikulum'],
            'atasan_with_performa',
            function ($sheet, $pengguna) {
                $currentRow = 2;
                foreach ($pengguna as $item) {
                    foreach ($item->performa as $performaItem) {
                        $alumniFromPerforma = $performaItem->alumni ?? null;
                        if ($alumniFromPerforma && $alumniFromPerforma->kategori_profesi !== null) {
                            $sheet->setCellValue('A' . $currentRow, $item->nama);
                            $sheet->setCellValue('B' . $currentRow, $item->jabatan);
                            $sheet->setCellValue('C' . $currentRow, $item->no_hp);
                            $sheet->setCellValue('D' . $currentRow, $item->email);

                            $sheet->setCellValue('E' . $currentRow, $alumniFromPerforma->nama ?? '');
                            $sheet->setCellValue('F' . $currentRow, $alumniFromPerforma->nim ?? '');
                            $sheet->setCellValue('G' . $currentRow, $alumniFromPerforma->programStudi->nama_prodi ?? '');

                            $sheet->setCellValue('H' . $currentRow, $performaItem->kerjasama_tim ?? '');
                            $sheet->setCellValue('I' . $currentRow, $performaItem->keahlian_ti ?? '');
                            $sheet->setCellValue('J' . $currentRow, $performaItem->bahasa_asing ?? '');
                            $sheet->setCellValue('K' . $currentRow, $performaItem->komunikasi ?? '');
                            $sheet->setCellValue('L' . $currentRow, $performaItem->pengembangan_diri ?? '');
                            $sheet->setCellValue('M' . $currentRow, $performaItem->kepemimpinan ?? '');
                            $sheet->setCellValue('N' . $currentRow, $performaItem->etos_kerja ?? '');
                            $sheet->setCellValue('O' . $currentRow, $performaItem->kompetensi_kurang ?? '');
                            $sheet->setCellValue('P' . $currentRow, $performaItem->saran_kurikulum ?? '');
                            $currentRow++;
                        }
                    }
                }
            },
            true
        );

        // Atasan without Performa
        $queryPerformaWithoutIsi = Performa::with(['pengguna', 'alumni.programStudi'])
            ->whereNull('kerjasama_tim');

        // Jika ingin filter alumni terkait di sini juga:
        if ($prodi || $tahunAwal || $tahunAkhir) {
            $queryPerformaWithoutIsi->whereHas('alumni', function ($q) use ($prodi, $tahunAwal, $tahunAkhir) {
                $this->applyBaseFilter($q, $prodi, $tahunAwal, $tahunAkhir);
            });
        }

        $filesToZip['Rekap Pengguna Lulusan Belum Isi Survey.xlsx'] = $this->generateExcel(
            $queryPerformaWithoutIsi->get(),
            ['Nama Atasan', 'Jabatan', 'No HP', 'Email', 'Nama Alumni', 'NIM Alumni', 'Program Studi Alumni'],
            'atasan_belum_isi_performa',
            function ($sheet, $data) {
                foreach ($data as $index => $item) {
                    $row = $index + 2;

                    $atasan = $item->pengguna;
                    $alumni = $item->alumni;

                    $sheet->setCellValue('A' . $row, $atasan->nama ?? '');
                    $sheet->setCellValue('B' . $row, $atasan->jabatan ?? '');
                    $sheet->setCellValue('C' . $row, $atasan->no_hp ?? '');
                    $sheet->setCellValue('D' . $row, $atasan->email ?? '');
                    $sheet->setCellValue('E' . $row, $alumni->nama ?? '');
                    $sheet->setCellValue('F' . $row, $alumni->nim ?? '');
                    $sheet->setCellValue('G' . $row, $alumni->programStudi->nama_prodi ?? '');
                }
            },
            true
        );

        foreach ($filesToZip as $zipEntryName => $filePath) {
            if (file_exists($filePath)) {
                $zip->addFile($filePath, $zipEntryName);
            }
        }

        $zip->close();

        foreach ($filesToZip as $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    return back()->with('error', 'Gagal membuat file export');
}

private function applyBaseFilter($query, $prodi, $tahunAwal, $tahunAkhir, $tableAlias = null)
{
    $prefix = $tableAlias ? $tableAlias . '.' : '';

    if ($prodi) {
        $query->where($prefix . 'prodi_id', $prodi);
    }
    if ($tahunAwal) {
        $query->whereYear($prefix . 'tanggal_lulus', '>=', $tahunAwal);
    }
    if ($tahunAkhir) {
        $query->whereYear($prefix . 'tanggal_lulus', '<=', $tahunAkhir);
    }
}

}
