<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MataKuliahController;

// =============================
// Halaman login default
// =============================
Route::get('/', function () {
    return view('auth.login');
});

// =============================
// Route bawaan Laravel Auth
// (login, register, dll)
// =============================
Auth::routes();

// =============================
// Home setelah login
// =============================
Route::get('/home', [HomeController::class, 'index'])->name('home');

// =============================
// Dashboard
// =============================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// =============================
// CRUD Mata Kuliah
// =============================
// otomatis membuat:
// GET     /matakuliah           → index
// GET     /matakuliah/create    → create
// POST    /matakuliah           → store
// GET     /matakuliah/{id}/edit → edit
// PUT     /matakuliah/{id}      → update
// DELETE  /matakuliah/{id}      → destroy
// =============================
Route::resource('matakuliah', MataKuliahController::class);
