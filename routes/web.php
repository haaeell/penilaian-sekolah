<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruKaryawanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstrumenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->name('admin.dashboard')->middleware('auth');
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admin', AdminController::class)->except('create', 'show', 'edit');
    Route::resource('guru', GuruController::class);
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('users', UserController::class);
    Route::resource('instrumen', InstrumenController::class);
    Route::resource('periode', PeriodeController::class);
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::resource('penilaian', PenilaianController::class);
});

Route::middleware(['auth', 'role:guru,karyawan'])->group(function () {
    Route::get('/hasil-penilaian', [PenilaianController::class, 'hasilPenilaian'])->name('hasil.penilaian');
    Route::get('/hasil-penilaian/download', [PenilaianController::class, 'downloadHasil'])->name('hasil.penilaian.download');
});

Auth::routes();
