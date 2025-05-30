<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AlumniImport;
use Illuminate\Support\Facades\Mail;

class AlumniController extends Controller
{
    /**
     * Menampilkan semua data alumni.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $prodi = session('filter.prodi');
        $tahunAwal = session('filter.tahun_awal');
        $tahunAkhir = session('filter.tahun_akhir');

        $query = Alumni::with('programStudi');

        if ($prodi) {
            $query->where('prodi_id', $prodi);
        }

        if ($tahunAwal) {
            $query->whereYear('tanggal_lulus', '>=', $tahunAwal);
        }

        if ($tahunAkhir) {
            $query->whereYear('tanggal_lulus', '<=', $tahunAkhir);
        }

        $alumni = $query->paginate(10);
        $programStudi = ProgramStudi::all();

        return view('alumni.index', compact('alumni', 'programStudi', 'prodi', 'tahunAwal', 'tahunAkhir'));
    }

    /**
     * Menampilkan form untuk membuat alumni baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $programStudi = ProgramStudi::all();
        return view('alumni.create', compact('programStudi'));
    }

    /**
     * Menyimpan data alumni baru.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|numeric|unique:alumni,nim',
            'prodi_id' => 'required|exists:program_studi,prodi_id',
            'email' => 'required|email|unique:alumni,email',
            'no_hp' => 'nullable|numeric|digits_between:10,15',
            'jenis_instansi' => 'nullable|string|max:100',
            'nama_instansi' => 'nullable|string|max:255',
            'skala_instansi' => 'nullable|string|max:50',
            'lokasi_instansi' => 'nullable|string|max:255',
            'kategori_profesi' => 'nullable|string|max:100',
            'profesi' => 'nullable|string|max:255',
            'tanggal_lulus' => 'nullable|date',
            'tanggal_pertama_kerja' => 'nullable|date|',
            'token' => 'nullable|string|max:100',
            'is_infokom' => 'nullable|boolean',
        ]);

        try {
            Alumni::create($validatedData);
            return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil disimpan');
        } catch (\Exception $e) {
            Log::error('Error storing alumni: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan data alumni');
        }
    }

    /**
     * Menampilkan detail alumni berdasarkan id.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $alumni = Alumni::with('programStudi')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $alumni,
                'program_studi' => $alumni->programStudi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Menampilkan form untuk mengedit data alumni.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        try {
            $alumni = Alumni::findOrFail($id);
            $programStudi = ProgramStudi::all();

            return response()->json([
                'success' => true,
                'alumni' => $alumni,
                'programStudi' => $programStudi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data alumni'
            ], 500);
        }
    }

    /**
     * Update data alumni
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|numeric|unique:alumni,nim,' . $id . ',alumni_id',
            'prodi_id' => 'required|exists:program_studi,prodi_id',
            'email' => 'required|email|unique:alumni,email,' . $id . ',alumni_id',
            'no_hp' => 'nullable|numeric|digits_between:10,15',
            'jenis_instansi' => 'nullable|string|max:100',
            'nama_instansi' => 'nullable|string|max:255',
            'skala_instansi' => 'nullable|string|max:50',
            'lokasi_instansi' => 'nullable|string|max:255',
            'kategori_profesi' => 'nullable|string|max:100',
            'profesi' => 'nullable|string|max:255',
            'tanggal_lulus' => 'nullable|date',
            'tanggal_pertama_kerja' => 'nullable|date',
            'token' => 'nullable|string|max:100',
            'is_infokom' => 'nullable|boolean',
        ]);

        try {
            $alumni = Alumni::findOrFail($id);
            $oldEmail = $alumni->email;
            $oldPhone = $alumni->no_hp;

            $alumni->update($validatedData);

            $link = url('/form-alumni/' . $alumni->token);

            if ($validatedData['email'] !== $oldEmail && $alumni->email) {
                Mail::to($alumni->email)->send(new \App\Mail\TracerStudyLinkMail($alumni, $link));
            }

            if ($validatedData['no_hp'] !== $oldPhone && $alumni->no_hp) {
                $message = "*Halo {$alumni->nama}* 👋

Kami dari *Tim Tracer Study POLINEMA* mengundang Anda untuk berpartisipasi dalam pengisian *Tracer Study Alumni*.

📝 Silakan isi formulir melalui link berikut:
{$link}

Partisipasi Anda sangat berarti untuk pengembangan institusi dan peningkatan kualitas lulusan.

Terima kasih atas waktunya 🙏
Salam hormat,
*Tim Tracer Study POLINEMA*";

                $this->sendWhatsAppMessage($alumni->no_hp, $message);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data alumni berhasil diperbarui',
                'data' => $alumni
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating alumni: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data alumni'
            ], 500);
        }
    }


    /**
     * Menghapus data alumni berdasarkan id.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $alumni = Alumni::findOrFail($id);
            $alumni->delete();

            return redirect()->route('alumni.index')
                ->with('success', 'Data alumni berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting alumni: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data alumni');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new AlumniImport, $request->file('file'));

        return back()->with('success', 'Data alumni berhasil diimpor.');
    }

    private function sendWhatsAppMessage($toNumber, $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_WHATSAPP_FROM');

        $client = new \Twilio\Rest\Client($sid, $token);

        try {
            $client->messages->create(
                "whatsapp:+62" . ltrim($toNumber, '0'),
                [
                    'from' => $twilioNumber,
                    'body' => $message
                ]
            );
        } catch (\Exception $e) {
            Log::error("Gagal kirim WA ke {$toNumber}: " . $e->getMessage());
        }
    }
}
