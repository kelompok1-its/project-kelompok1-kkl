<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\RoleSwitchController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/home', function () {
        return redirect()->route('dashboard.role', ['role' => 'akademik']);
    })->name('home');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/{role}', [DashboardController::class, 'showByRole'])
        ->where('role', 'akademik|kaprodi|dekan|wr1|dosen')
        ->name('dashboard.role');

    // CRUD Mata Kuliah
    Route::resource('matakuliah', MataKuliahController::class);

    // CRUD Kelas
    Route::resource('kelas', KelasController::class)
        ->parameters([
            'kelas' => 'kelas'
        ]);

    // Role Switcher
    Route::post('/switch-role', [RoleSwitchController::class, 'switch'])
        ->name('role.switch');

    Route::get('/switch-role/{role}', [RoleSwitchController::class, 'switch'])
        ->where('role', 'akademik|kaprodi|dekan|wr1|dosen')
        ->name('role.switch.get');

    // Debug role
    Route::get('/current-role', function () {
        return response()->json([
            'slug'  => session('current_role_slug'),
            'label' => session('current_role'),
        ]);
    })->name('role.current');
});
