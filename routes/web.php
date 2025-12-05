<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\RoleSwitchController;
use App\Http\Controllers\KelasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Simple and ready-to-copy routes file:
| - '/' -> login
| - '/home' -> redirect ke dashboard/akademik
| - '/dashboard' + '/dashboard/{role}'
| - resources: matakuliah, kelas
| - role switcher (POST)
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth scaffolding (login, register, password reset, etc.)
Auth::routes();

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {

    // Keep /home for compatibility, forward to akademik dashboard
    Route::get('/home', function () {
        return redirect()->route('dashboard.role', ['role' => 'akademik']);
    })->name('home');

    // General dashboard (controller will decide show/redirect)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Role-specific dashboard (constrained)
    Route::get('/dashboard/{role}', [DashboardController::class, 'showByRole'])
        ->where('role', 'akademik|kaprodi|dekan|wr1|dosen')
        ->name('dashboard.role');

    // CRUD Mata Kuliah
    Route::resource('matakuliah', MataKuliahController::class);

    // CRUD Kelas (simple global resource; route name: kelas.index, etc.)
    Route::resource('kelas', KelasController::class);

    // Bind 'kelas' explicitly
    Route::bind('kela', function ($value) {
        return \App\Models\Kelas::findOrFail($value);
    });

    // atau lebih simple, override route parameter name
    Route::resource('kelas', App\Http\Controllers\KelasController::class)->parameters([
        'kelas' => 'kelas'  // paksa pakai 'kelas' bukan 'kela'
    ]);

    // Role switcher (canonical POST endpoint used by the UI)
    Route::post('/switch-role', [RoleSwitchController::class, 'switch'])
        ->name('role.switch');

    // Optional GET compatibility for switching role by URL (named differently)
    Route::get('/switch-role/{role}', [RoleSwitchController::class, 'switch'])
        ->where('role', 'akademik|kaprodi|dekan|wr1|dosen')
        ->name('role.switch.get');

    // Debug helper to inspect current session role
    Route::get('/current-role', function () {
        return response()->json([
            'slug'  => session('current_role_slug', null),
            'label' => session('current_role', null),
        ]);
    })->name('role.current');
});
