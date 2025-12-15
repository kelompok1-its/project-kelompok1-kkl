<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/* ======================
   CONTROLLERS
======================= */
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SkMengajarController;
use App\Http\Controllers\RoleSwitchController;

use App\Http\Controllers\KaprodiKuisionerController;
use App\Http\Controllers\DosenKuisionerController;
use App\Http\Controllers\JawabanKuisionerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/* ======================
   AUTH
======================= */
Auth::routes();

/* ======================
   PROTECTED ROUTES
======================= */
Route::middleware(['auth'])->group(function () {

    /* ======================
       HOME
    ======================= */
    Route::get('/home', function () {
        return redirect()->route('dashboard.role', 'akademik');
    })->name('home');

    /* ======================
       DASHBOARD MULTI ROLE
    ======================= */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/{role}', [DashboardController::class, 'showByRole'])
        ->where('role', 'akademik|kaprodi|dekan|wr1|dosen')
        ->name('dashboard.role');

    /* ======================
       MATA KULIAH
    ======================= */
    Route::resource('matakuliah', MataKuliahController::class);

    /* ======================
       KELAS
    ======================= */
    Route::resource('kelas', KelasController::class);

    /* ======================
       SK MENGAJAR
    ======================= */
    Route::resource('sk_mengajar', SkMengajarController::class);

    /* ======================
       ROLE SWITCHER
    ======================= */
    Route::post('/switch-role', [RoleSwitchController::class, 'switch'])
        ->name('role.switch');

    Route::get('/switch-role/{role}', [RoleSwitchController::class, 'switch'])
        ->where('role', 'akademik|kaprodi|dekan|wr1|dosen')
        ->name('role.switch.get');

    /* =========================================================
       KUISONER — KAPRODI
       views/kaprodi/kuisioner/*
    ========================================================= */
    Route::prefix('kaprodi/kuisioner')->group(function () {

        Route::get('/', [KaprodiKuisionerController::class, 'index'])
            ->name('kaprodi.kuisioner.index');

        Route::get('/create', [KaprodiKuisionerController::class, 'create'])
            ->name('kaprodi.kuisioner.create');

        Route::post('/store', [KaprodiKuisionerController::class, 'store'])
            ->name('kaprodi.kuisioner.store');

        Route::get('/hasil', [KaprodiKuisionerController::class, 'hasil'])
            ->name('kaprodi.kuisioner.hasil');
    });

    /* =========================================================
       KUISONER — DOSEN
       views/dosen/kuisioner/*
    ========================================================= */
    Route::prefix('dosen/kuisioner')->group(function () {

        Route::get('/', [DosenKuisionerController::class, 'index'])
            ->name('dosen.kuisioner.index');

        Route::post('/jawab', [JawabanKuisionerController::class, 'store'])
            ->name('dosen.kuisioner.jawab');
    });
});
