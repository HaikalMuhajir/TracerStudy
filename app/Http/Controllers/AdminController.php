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

    public function mahasiswa(Request $request): View
    {
        // Menentukan judul halaman dan menu aktif
        $pageTitle = 'Data Mahasiswa';
        $activeMenu = 'mahasiswa';
    
        // Breadcrumb untuk navigasi
        $breadcrumb = [
            ['label' => 'Data Mahasiswa'],
        ];
    
        // Ambil query pencarian dari request
        $search = $request->input('search', '');
    
        // Mengambil data mahasiswa sesuai pencarian
        $mahasiswas = Alumni::with(['programStudi', 'user'])
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
        return view('admin.mahasiswa.index', compact('pageTitle', 'breadcrumb', 'activeMenu', 'mahasiswas'));
    }
    

    // Login form display
     public function login(): View
     {
         $pageTitle = 'Login';
         return view('login', compact('pageTitle'));
     }

     // Handle login attempt
     public function authenticate(Request $request)
     {
         $request->validate([
             'email' => 'required|email',
             'password' => 'required|string',
         ]);

         // Attempt to log in the user
         if (Auth::attempt($request->only('email', 'password'))) {
             // Authentication passed, redirect to the dashboard
             return redirect()->intended('/admin/dashboard');
         }

         // Authentication failed, redirect back with error message
         throw ValidationException::withMessages([
             'email' => ['The provided credentials are incorrect.'],
         ]);
     }

     // Handle logout
     public function logout()
     {
         Auth::logout();
         return redirect('/login');
     }

     // AdminController.php

     public function showDetail($alumni_id)
    {
        $mahasiswa = Alumni::with(['user', 'programStudi'])
                        ->findOrFail($alumni_id);
        
        return response()->json($mahasiswa);
    }

     public function edit($alumni_id)
     {
         // Mengambil data alumni beserta relasi program studi dan user
         $mahasiswa = Alumni::with('user', 'programStudi')->findOrFail($alumni_id);
     
         // Mengambil semua data program studi
         $programStudi = ProgramStudi::all();
     
         return response()->json([
             'mahasiswa' => $mahasiswa,
             'programStudi' => $programStudi,
         ]);
     }
     

     
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
         $mahasiswa = Alumni::findOrFail($alumni_id);  // Mengambil data berdasarkan alumni_id
     
         // Update data alumni dan nama user
         $mahasiswa->user->name = $request->nama;  // Update nama user
         $mahasiswa->nim = $request->nim;
         $mahasiswa->no_hp = $request->no_hp;
         $mahasiswa->jenis_instansi = $request->jenis_instansi;
         $mahasiswa->nama_instansi = $request->nama_instansi;
         $mahasiswa->skala_instansi = $request->skala_instansi;
         $mahasiswa->lokasi_instansi = $request->lokasi_instansi;
         $mahasiswa->kategori_profesi = $request->kategori_profesi;
         $mahasiswa->profesi = $request->profesi;
         $mahasiswa->tanggal_lulus = $request->tanggal_lulus;
         $mahasiswa->tahun_lulus = $request->tahun_lulus;
         $mahasiswa->tanggal_pertama_kerja = $request->tanggal_pertama_kerja;
         $mahasiswa->prodi_id = $request->program_studi;  // Update program studi ID
     
         // Simpan perubahan ke database
         $mahasiswa->user->save();  // Save user name
         $mahasiswa->save();  // Save alumni data
     
         // Kembalikan respon sebagai JSON
         return response()->json(['success' => true, 'message' => 'Data mahasiswa berhasil diperbarui']);
     }

     public function delete($alumni_id)
     {
         try {
             $mahasiswa = Alumni::with('user')->findOrFail($alumni_id);
             DB::beginTransaction();
             
             if ($mahasiswa->user) {
                 $mahasiswa->user->delete();
             }
             
             $mahasiswa->delete();
             DB::commit();
             
             return response()->json([
                 'success' => true,
                 'message' => 'Data mahasiswa berhasil dihapus'
             ]);
             
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             return response()->json([
                 'success' => false,
                 'message' => 'Data mahasiswa tidak ditemukan'
             ], 404);
             
         } catch (\Exception $e) {
             DB::rollBack();
             return response()->json([
                 'success' => false,
                 'message' => 'Gagal menghapus data mahasiswa: ' . $e->getMessage()
             ], 500);
         }
     }

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

        $mahasiswas = $query->with(['user', 'programStudi'])->get();

        return response()->json($mahasiswas);
    }

}
