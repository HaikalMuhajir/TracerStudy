<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpLoginController;
use App\Http\Controllers\Auth\SetPasswordController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('auth.login'))->name('login');

// Login via OTP
Route::post('/otp-send', [OtpLoginController::class, 'sendOtp'])->name('otp.send');
Route::get('/otp-verify', [OtpLoginController::class, 'showVerifyForm'])->name('otp.verify.form');
Route::post('/otp-verify', [OtpLoginController::class, 'verifyOtp'])->name('otp.verify');

// Set password setelah OTP login
Route::middleware('auth')->group(function () {
    Route::get('/set-password', [SetPasswordController::class, 'showForm'])->name('password.set.form');
    Route::post('/set-password', [SetPasswordController::class, 'store'])->name('password.set');
});

// Redirect dashboard sesuai role
Route::middleware('auth')->get('/dashboard', function () {
    $user = Auth::user();
    return $user->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('alumni.dashboard');
})->name('dashboard');

// Dashboard masing-masing role
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/alumni/dashboard', fn() => view('alumni.dashboard'))->name('alumni.dashboard');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
