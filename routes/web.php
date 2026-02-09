<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InstitusiController as AdminInstitusiController;
use App\Http\Controllers\Admin\PesertaController as AdminPesertaController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\ValidationController as AdminValidationController;
use App\Http\Controllers\Institusi\DashboardController as InstitusiDashboardController;
use App\Http\Controllers\Institusi\PesertaController as InstitusiPesertaController;
use App\Http\Controllers\Institusi\LaporanController as InstitusiLaporanController;
use App\Http\Controllers\Institusi\PendaftaranController;
use App\Http\Controllers\Institusi\ProfilController as InstitusiProfilController;
use App\Http\Controllers\Peserta\DashboardController as PesertaDashboardController;
use App\Http\Controllers\Peserta\LaporanController as PesertaLaporanController;
use App\Http\Controllers\Peserta\ProfilController as PesertaProfilController;
use App\Http\Controllers\Peserta\StatusController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/masuk', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/masuk', [LoginController::class, 'login'])->name('login.submit');
    
    // Register
    Route::get('/daftar', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/daftar', [RegisterController::class, 'register'])->name('register.submit');
});

// Logout
Route::post('/keluar', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware([
        'auth:admin',
        RoleMiddleware::class . ':ADMIN,SUPERADMIN'
    ])
    ->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Institusi Management
    Route::prefix('dashboard/institusi')->name('institusi.')->group(function () {
        Route::get('/', [AdminInstitusiController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminInstitusiController::class, 'show'])->name('show');
        Route::get('/{id}/peserta', [AdminInstitusiController::class, 'showPeserta'])->name('peserta');
    });
    
    // Peserta Management
    Route::prefix('dashboard/peserta')->name('peserta.')->group(function () {
        Route::get('/', [AdminPesertaController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminPesertaController::class, 'show'])->name('show');
    });
    
    // Laporan Management
    Route::prefix('dashboard/laporan')->name('laporan.')->group(function () {
        Route::get('/', [AdminLaporanController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminLaporanController::class, 'show'])->name('show');
    });
    
    // Validasi
    Route::prefix('dashboard/validasi')->name('validasi.')->group(function () {
        Route::get('/institusi', [AdminValidationController::class, 'institusi'])->name('institusi');
        Route::get('/peserta', [AdminValidationController::class, 'peserta'])->name('peserta');
        Route::get('/peserta/{id}', [AdminValidationController::class, 'pesertaShow'])->name('peserta.show');
        Route::post('/peserta/{id}/acc', [AdminValidationController::class, 'accPeserta'])->name('peserta.acc');
        Route::post('/peserta/{id}/reject', [AdminValidationController::class, 'rejectPeserta'])->name('peserta.reject');
        Route::post('/institusi/{id}/acc', [AdminValidationController::class, 'accInstitusi'])->name('institusi.acc');
        Route::post('/institusi/{id}/reject', [AdminValidationController::class, 'rejectInstitusi'])->name('institusi.reject');
    });
});

/*
|--------------------------------------------------------------------------
| Institusi Routes
|--------------------------------------------------------------------------
*/

Route::prefix('institusi')
    ->name('institusi.')
    ->middleware([
        'auth',
        RoleMiddleware::class . ':INSTITUSI'
    ])
    ->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [InstitusiDashboardController::class, 'index'])->name('dashboard');
    
    // Profil
    Route::get('/dashboard/profil', [InstitusiProfilController::class, 'index'])->name('profil');
    Route::put('/dashboard/profil', [InstitusiProfilController::class, 'update'])->name('profil.update');
    
    // Peserta Management
    Route::prefix('dashboard/peserta')->name('peserta.')->group(function () {
        Route::get('/', [InstitusiPesertaController::class, 'index'])->name('index');
        Route::get('/create', [InstitusiPesertaController::class, 'create'])->name('create');
        Route::post('/', [InstitusiPesertaController::class, 'store'])->name('store');
        Route::get('/{id}', [InstitusiPesertaController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [InstitusiPesertaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [InstitusiPesertaController::class, 'update'])->name('update');
        Route::delete('/{id}', [InstitusiPesertaController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/laporan', [InstitusiPesertaController::class, 'laporan'])->name('laporan');
    });
    
    // Pendaftaran
    Route::prefix('dashboard/pendaftaran')->name('pendaftaran.')->group(function () {
        Route::get('/', [PendaftaranController::class, 'index'])->name('index');
        Route::post('/', [PendaftaranController::class, 'store'])->name('store');
        Route::get('/{id}', [PendaftaranController::class, 'show'])->name('show');
    });
    
    // Laporan
    Route::prefix('dashboard/laporan')->name('laporan.')->group(function () {
        Route::get('/', [InstitusiLaporanController::class, 'index'])->name('index');
        Route::get('/{peserta_id}', [InstitusiLaporanController::class, 'show'])->name('show');
    });
});

/*
|--------------------------------------------------------------------------
| Peserta Routes
|--------------------------------------------------------------------------
*/

Route::prefix('peserta')
    ->name('peserta.')
    ->middleware([
        'auth',
        RoleMiddleware::class . ':PESERTA'
    ])
    ->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [PesertaDashboardController::class, 'index'])->name('dashboard');
    
    // Profil
    Route::get('/dashboard/profil', [PesertaProfilController::class, 'index'])->name('profil');
    Route::put('/dashboard/profil', [PesertaProfilController::class, 'update'])->name('profil.update');
    
    // Status Pendaftaran
    Route::get('/dashboard/status', [StatusController::class, 'index'])->name('status');
    
    // Laporan
    Route::prefix('dashboard/laporan')->name('laporan.')->group(function () {
        Route::get('/', [PesertaLaporanController::class, 'index'])->name('index');
        Route::get('/create', [PesertaLaporanController::class, 'create'])->name('create');
        Route::post('/', [PesertaLaporanController::class, 'store'])->name('store');
        Route::get('/{id}', [PesertaLaporanController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PesertaLaporanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PesertaLaporanController::class, 'update'])->name('update');
        Route::delete('/{id}', [PesertaLaporanController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
