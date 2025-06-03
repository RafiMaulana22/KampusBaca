<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\FakultasController;
use App\Http\Controllers\admin\JurusanController;
use App\Http\Controllers\admin\MahasiswaController;
use App\Http\Controllers\admin\StaffController;
use App\Http\Controllers\auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'action_login'])->name('login');

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'action_register'])->name('register');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Fakultas routes
    Route::get('/fakultas', [FakultasController::class, 'index'])->name('fakultas.index');
    Route::post('/fakultas', [FakultasController::class, 'store'])->name('fakultas.store');

    Route::post('/fakultas/{fakultas}/update', [FakultasController::class, 'update'])->name('fakultas.update');

    Route::get('/fakultas/{fakultas}/destroy', [FakultasController::class, 'destroy'])->name('fakultas.destroy');

    // Jurusan routes
    Route::get('/jurusan/{fakultas}', [JurusanController::class, 'index'])->name('jurusan.index');

    Route::post('/jurusan/{fakultas}', [JurusanController::class, 'store'])->name('jurusan.store');

    Route::get('/jurusan/{fakultas}/{jurusan}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
    Route::post('/jurusan/{fakultas}/{jurusan}/update', [JurusanController::class, 'update'])->name('jurusan.update');

    Route::get('/jurusan/{fakultas}/{jurusan}/destroy', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

    // Mahasiswa routes
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');

    Route::get('/mahasiswa/tambah', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('/mahasiswa/tambah', [MahasiswaController::class, 'store'])->name('mahasiswa.store');

    Route::get('/mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::post('/mahasiswa/{mahasiswa}/update', [MahasiswaController::class, 'update'])->name('mahasiswa.update');

    Route::get('/mahasiswa/{mahasiswa}/detail', [MahasiswaController::class, 'detail'])->name('mahasiswa.detail');

    Route::get('/mahasiswa/verifikasi', [MahasiswaController::class, 'verifikasi'])->name('mahasiswa.verifikasi');
    Route::patch('/mahasiswa/{mahasiswa}/verify', [MahasiswaController::class, 'status'])->name('mahasiswa.status');

    Route::get('/mahasiswa/{mahasiswa}/destroy', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

    // Staff routes
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');

    Route::get('/staff/tambah', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff/tambah', [StaffController::class, 'store'])->name('staff.store');

    Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::post('/staff/{staff}/update', [StaffController::class, 'update'])->name('staff.update');

    Route::get('/staff/{staff}/detail', [StaffController::class, 'detail'])->name('staff.detail');

    Route::get('/staff/{staff}/destroy', [StaffController::class, 'destroy'])->name('staff.destroy');

    // Logout routes
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
