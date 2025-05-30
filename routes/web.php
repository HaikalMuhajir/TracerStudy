<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Profile Routes~
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Alumni Routes
    Route::prefix('alumni')->group(function () {
        Route::get('/', [AlumniController::class, 'index'])->name('alumni.index');
        Route::get('/create', [AlumniController::class, 'create'])->name('alumni.create');
        Route::post('/', [AlumniController::class, 'store'])->name('alumni.store');
        Route::get('/{id}/show', [AlumniController::class, 'show'])->name('alumni.show');
        Route::get('/{id}/edit', [AlumniController::class, 'edit'])->name('alumni.edit');
        Route::put('/{id}', [AlumniController::class, 'update'])->name('alumni.update');
        Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('alumni.destroy');
        Route::get('/filter', [AlumniController::class, 'filter'])->name('alumni.filter');
        Route::get('/data', [AlumniController::class, 'getData'])->name('alumni.data');
        Route::post('/import', [AlumniController::class, 'import'])->name('alumni.import');

    });

    // Filter Form
    Route::post('/filter/set', [FilterController::class, 'set'])->name('filter.set');
    Route::get('/filter/reset', [FilterController::class, 'reset'])->name('filter.reset');
});

require __DIR__ . '/auth.php';

Route::prefix('export')->group(function () {
    Route::get('alumni-with-atasan', [ExportController::class, 'exportAlumniWithAtasan'])->name('export.alumni_with_atasan');
    Route::get('alumni-without-atasan', [ExportController::class, 'exportAlumniWithoutAtasan'])->name('export.alumni_without_atasan');
    Route::get('atasan-with-performa', [ExportController::class, 'exportAtasanWithPerforma'])->name('export.atasan_with_performa');
    Route::get('atasan-without-performa', [ExportController::class, 'exportAtasanWithoutPerforma'])->name('export.atasan_without_performa');
    Route::get('all', [ExportController::class, 'exportAll'])->name('export.all');
});
