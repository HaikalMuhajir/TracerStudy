<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('login'); // Buat file resources/views/login.blade.php sederhana
    }

    // public function login(Request $request)
    // {
    //     // Logika login akan diimplementasikan nanti setelah database siap
    // }
}