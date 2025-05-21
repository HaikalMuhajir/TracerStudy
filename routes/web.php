<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\statusController;

// Rute untuk login dan dashboard
Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

// Rute login dan logout
Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.login.submit');
Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Rute untuk dashboard admin
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Rute untuk alumni
Route::get('/alumni', [AdminController::class, 'alumni'])->name('admin.alumni.alumni');  // Halaman utama alumni
Route::get('/alumni/detail/{alumni_id}', [AdminController::class, 'showDetail'])->name('admin.alumni.detail');
Route::get('/alumni/edit/{alumni_id}', [AdminController::class, 'edit'])->name('admin.alumni.edit');

// Rute untuk memperbarui dan menghapus alumni
Route::put('/alumni/update/{alumni_id}', [AdminController::class, 'update'])->name('admin.alumni.update');
Route::delete('/alumni/delete/{alumni_id}', [AdminController::class, 'delete'])->name('admin.alumni.delete');

// Rute untuk pencarian alumni
Route::get('/alumni/search', [AdminController::class, 'search'])->name('admin.alumni.search');

// Rute untuk update status alumni
Route::post('/update-status', [statusController::class, 'updateStatus'])->name('update.status');
