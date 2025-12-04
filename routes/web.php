<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\RoleSwitchController;

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
// Protected routes (requires authentication)
// =============================
Route::middleware(['auth'])->group(function () {

    // Home setelah login
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Dashboard umum
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard per role
    Route::get('/dashboard/{role}', [DashboardController::class, 'showByRole'])
        ->name('dashboard.role');

    // CRUD Mata Kuliah
    Route::resource('matakuliah', MataKuliahController::class);

    // ===== Role switcher =====
    // POST endpoint (CSRF-safe) -> dinamai role.switch
    Route::post('/switch-role', [RoleSwitchController::class, 'switch'])
        ->name('role.switch');

    // Optional: compatibility GET route WITH DIFFERENT NAME
    // If you don't need the GET variant, you can remove this line.
    Route::get('/switch-role/{role}', [RoleSwitchController::class, 'switch'])
        ->name('role.switch.get');

    // Optional: debug current role
    Route::get('/current-role', function () {
        return response()->json([
            'slug' => session('current_role_slug', 'akademik'),
            'label' => session('current_role', 'Akademik'),
        ]);
    })->name('role.current');
});
// =============================
// End protected routes
// =============================