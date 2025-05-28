<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Menampilkan semua data alumni.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Perbaikan: Tambahkan eager loading dengan relasi programStudi
        $alumni = Alumni::with(['programStudi' => function($query) {
            $query->select('prodi_id', 'nama_prodi');
        }])->get();
        
        // Perbaikan: Kirim juga $programStudi ke view jika diperlukan untuk form
        $programStudi = ProgramStudi::all();
        
        return view('alumni.index', compact('alumni', 'programStudi'));
    }

    /**
     * Menampilkan form untuk membuat alumni baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Ambil semua program studi untuk dropdown di form create
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
        // Validate the incoming request
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|numeric',
            'prodi_id' => 'required|exists:program_studi,prodi_id',
            'email' => 'required|email',
            'no_hp' => 'nullable|numeric',
            'jenis_instansi' => 'nullable|string',
            'nama_instansi' => 'nullable|string',
            'skala_instansi' => 'nullable|string',
            'lokasi_instansi' => 'nullable|string',
            'kategori_profesi' => 'nullable|string',
            'profesi' => 'nullable|string',
            'tanggal_lulus' => 'nullable|date',
            'tanggal_pertama_kerja' => 'nullable|date',
            'token' => 'nullable|string',
            'is_infokom' => 'nullable|boolean',
        ]);
    
        // Create a new alumni record
        $alumni = Alumni::create([
            'nama' => $request->nama,
            'prodi_id' => $request->prodi_id,
            'nim' => $request->nim,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'jenis_instansi' => $request->jenis_instansi,
            'nama_instansi' => $request->nama_instansi,
            'skala_instansi' => $request->skala_instansi,
            'lokasi_instansi' => $request->lokasi_instansi,
            'kategori_profesi' => $request->kategori_profesi,
            'profesi' => $request->profesi,
            'tanggal_lulus' => $request->tanggal_lulus,
            'tanggal_pertama_kerja' => $request->tanggal_pertama_kerja,
            'token' => $request->token,
            'is_infokom' => $request->is_infokom,
        ]);
    
        // Respond with a success message
        return response()->json(['success' => true, 'message' => 'Data alumni berhasil ditambahkan'], 200);
    }
    
    /**
     * Menampilkan detail alumni berdasarkan id.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $alumni = Alumni::with('programStudi')->findOrFail($id);
        return response()->json($alumni); // Pastikan response JSON dikirimkan
    }
    


    

    /**
     * Menampilkan form untuk mengedit data alumni.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    // Fungsi untuk menampilkan data modal edit
    public function edit($id)
    {
        $alumni = Alumni::with('programStudi')->findOrFail($id);
        $programStudi = ProgramStudi::select('prodi_id', 'nama_prodi')->get();
        
        return response()->json([
            'alumni' => $alumni,
            'programStudi' => $programStudi,
            'current_prodi' => $alumni->programStudi // Tambahkan ini untuk debug
        ]);
    }

    /**
     * Memperbarui data alumni berdasarkan id.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|numeric',
            'prodi' => 'required|exists:program_studi,prodi_id',
            'email' => 'required|email',
            'no_hp' => 'nullable|numeric',
            'jenis_instansi' => 'nullable|string',
            'nama_instansi' => 'nullable|string',
            'skala_instansi' => 'nullable|string',
            'lokasi_instansi' => 'nullable|string',
            'kategori_profesi' => 'nullable|string',
            'profesi' => 'nullable|string',
            'tanggal_lulus' => 'nullable|date',
            // 'tahun_lulus' => 'nullable|date',
            'tanggal_pertama_kerja' => 'nullable|date',
            'token' => 'nullable|string',
            'is_infokom' => 'nullable|boolean',
        ]);
    
        $alumni = Alumni::findOrFail($id);
        
        $updateData = [
            'nama' => $validatedData['nama'],
            'prodi_id' => $validatedData['prodi'],
            'nim' => $validatedData['nim'],
            'email' => $validatedData['email'],
            'no_hp' => $validatedData['no_hp'],
            'jenis_instansi' => $validatedData['jenis_instansi'] ?? null,
            'nama_instansi' => $validatedData['nama_instansi'] ?? null,
            'skala_instansi' => $validatedData['skala_instansi'] ?? null,
            'lokasi_instansi' => $validatedData['lokasi_instansi'] ?? null,
            'kategori_profesi' => $validatedData['kategori_profesi'] ?? null,
            'profesi' => $validatedData['profesi'] ?? null,
            'tanggal_lulus' => $validatedData['tanggal_lulus'] ?? null,
            // 'tahun_lulus' => $validatedData['tahun_lulus'] ?? null,
            'tanggal_pertama_kerja' => $validatedData['tanggal_pertama_kerja'] ?? null,
            'token' => $validatedData['token'] ?? null,
            'is_infokom' => $validatedData['is_infokom'] ?? false,
        ];
    
        $alumni->update($updateData);
    
        // return response()->json(['success' => true, 'message' => 'Data alumni berhasil diperbarui']);
        // Redirect kembali ke halaman daftar alumni setelah update
        return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil diperbarui');
    }
    /**
     * Menghapus data alumni berdasarkan id.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Mengambil data alumni dan menghapusnya
        $alumni = Alumni::findOrFail($id);
        $alumni->delete();

        return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil dihapus');
    }
}
