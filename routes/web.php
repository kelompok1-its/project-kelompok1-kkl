<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\RoleSwitchController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SkMengajarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth scaffolding
Auth::routes();

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {

    // Home redirect
    Route::get('/home', function () {
        return redirect()->route('dashboard.role', ['role' => 'akademik']);
    })->name('home');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/{role}', [DashboardController::class, 'showByRole'])
        ->where('role', 'akademik|kaprodi|dekan|wr1|dosen')
        ->name('dashboard.role');

    // ===== CRUD RESOURCES =====

    // Mata Kuliah
    Route::resource('matakuliah', MataKuliahController::class);

    // Kelas (parameter override)
    Route::resource('kelas', KelasController::class)->parameters([
        'kelas' => 'kelas'
    ]);

    // SK Mengajar
    Route::resource('sk_mengajar', SkMengajarController::class)->parameters([
        'sk_mengajar' => 'skMengajar'
    ]);


    // ===== ROLE SWITCHER =====

    Route::post('/switch-role', [RoleSwitchController::class, 'switch'])
        ->name('role.switch');

    Route::get('/switch-role/{role}', [RoleSwitchController::class, 'switch'])
        ->where('role', 'akademik|kaprodi|dekan|wr1|dosen')
        ->name('role.switch.get');

    // Debug helper
    Route::get('/current-role', function () {
        return response()->json([
            'slug'  => session('current_role_slug', null),
            'label' => session('current_role', null),
        ]);
    })->name('role.current');
});
