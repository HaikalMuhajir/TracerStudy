<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\statusController;

Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.login.submit');
Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');


Route::get('/', [AdminController::class, 'dashboard']);

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/mahasiswa', [AdminController::class, 'mahasiswa'])->name('admin.mahasiswa.index');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

Route::post('/update-status', [statusController::class, 'updateStatus'])->name('update.status');

Route::view('/alumni', 'alumni.dashboard.index', ['activeMenu' => 'dashboard']);
