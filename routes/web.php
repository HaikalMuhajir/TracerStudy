<?php

use App\Http\Controllers\AuthController; // Atau controller lain yang akan menangani login
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'dashboard']);

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/mahasiswa', [AdminController::class, 'mahasiswa'])->name('admin.mahasiswa.index');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
// });
