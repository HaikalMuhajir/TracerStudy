<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use App\Models\Alumni;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $pageTitle = 'Dashboard';
        $activeMenu = 'dashboard';
        $breadcrumb = [
            ['label' => 'Dashboard'],
        ];

        return view('admin.dashboard', compact('pageTitle', 'breadcrumb', 'activeMenu'));
    }

    public function alumni(Request $request): View
    {
        // Menentukan judul halaman dan menu aktif
        $pageTitle = 'Data Alumni';
        $activeMenu = 'alumni';
    
        // Breadcrumb untuk navigasi
        $breadcrumb = [
            ['label' => 'Data Alumni'],
        ];
    
        // Ambil query pencarian dari request
        $search = $request->input('search', '');
    
        // Mengambil data alumni sesuai pencarian
        $alumnis = Alumni::with(['programStudi', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('nim', 'like', "%$search%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                });
            })
            ->paginate(10);  // Pagination untuk menampilkan data per halaman
    
        // Mengirim data ke view
        return view('admin.alumni.alumni', compact('pageTitle', 'breadcrumb', 'activeMenu', 'alumnis'));
    }
    
    // Login form display
    public function login(): View
    {
        $pageTitle = 'Login';
        return view('login', compact('pageTitle'));
    }

    // // Handle login attempt
    // public function authenticate(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //     ]);

    //     // Attempt to log in the user
    //     if (Auth::attempt($request->only('email', 'password'))) {
    //         // Authentication passed, redirect to the dashboard
    //         return redirect()->intended('/admin/dashboard');
    //     }

    //     // Authentication failed, redirect back with error message
    //     throw ValidationException::withMessages([
    //         'email' => ['The provided credentials are incorrect.'],
    //     ]);
    // }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // Show alumni details using AJAX
    public function showDetail($alumni_id)
    {
        $alumni = Alumni::with(['user', 'programStudi'])
                        ->findOrFail($alumni_id);
        
        return response()->json($alumni);
    }

    // Edit alumni data
    public function edit($alumni_id)
    {
        // Mengambil data alumni beserta relasi program studi dan user
        $alumni = Alumni::with('user', 'programStudi')->findOrFail($alumni_id);
    
        // Mengambil semua data program studi
        $programStudi = ProgramStudi::all();
    
        return response()->json([
            'alumni' => $alumni,
            'programStudi' => $programStudi,
        ]);
    }

    // Update alumni data
    public function update(Request $request, $alumni_id)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'nim' => 'required|string|max:20',
            'no_hp' => 'required|string|max:20',
            'jenis_instansi' => 'required|string',
            'nama_instansi' => 'required|string',
            'skala_instansi' => 'required|string',
            'lokasi_instansi' => 'required|string',
            'kategori_profesi' => 'required|string',
            'profesi' => 'required|string',
            'tanggal_lulus' => 'required|date',
            'tahun_lulus' => 'required|integer',
            'tanggal_pertama_kerja' => 'required|date',
            'program_studi' => 'required|integer', // Pastikan ini adalah integer
            'nama' => 'required|string',  // Validate name
        ]);
    
        // Temukan data alumni berdasarkan alumni_id
        $alumni = Alumni::findOrFail($alumni_id);  // Mengambil data berdasarkan alumni_id
    
        // Update data alumni dan nama user
        $alumni->user->name = $request->nama;  // Update nama user
        $alumni->nim = $request->nim;
        $alumni->no_hp = $request->no_hp;
        $alumni->jenis_instansi = $request->jenis_instansi;
        $alumni->nama_instansi = $request->nama_instansi;
        $alumni->skala_instansi = $request->skala_instansi;
        $alumni->lokasi_instansi = $request->lokasi_instansi;
        $alumni->kategori_profesi = $request->kategori_profesi;
        $alumni->profesi = $request->profesi;
        $alumni->tanggal_lulus = $request->tanggal_lulus;
        $alumni->tahun_lulus = $request->tahun_lulus;
        $alumni->tanggal_pertama_kerja = $request->tanggal_pertama_kerja;
        $alumni->prodi_id = $request->program_studi;  // Update program studi ID
    
        // Simpan perubahan ke database
        $alumni->user->save();  // Save user name
        $alumni->save();  // Save alumni data
    
        // Kembalikan respon sebagai JSON
        return response()->json(['success' => true, 'message' => 'Data alumni berhasil diperbarui']);
    }

    // Delete alumni data
    public function delete($alumni_id)
    {
        try {
            $alumni = Alumni::with('user')->findOrFail($alumni_id);
            DB::beginTransaction();
            
            if ($alumni->user) {
                $alumni->user->delete();
            }
            
            $alumni->delete();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Data alumni berhasil dihapus'
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data alumni tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data alumni: ' . $e->getMessage()
            ], 500);
        }
    }

    // Alumni search
    public function search(Request $request)
    {
        $query = Alumni::query();

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('nim', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }

        $alumnis = $query->with(['user', 'programStudi'])->get();

        return response()->json($alumnis);
    }
}
