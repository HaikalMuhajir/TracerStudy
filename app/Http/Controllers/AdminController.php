<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

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

    public function mahasiswa(): View
    {
        $pageTitle = 'Data Mahasiswa';
        $activeMenu = 'mahasiswa';
        $breadcrumb = [
            ['label' => 'Data Mahasiswa'],
        ];

        return view('admin.mahasiswa.index', compact('pageTitle', 'breadcrumb', 'activeMenu'));
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

    }
