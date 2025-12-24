<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SkMengajarController;
use App\Http\Controllers\RoleSwitchController;
use App\Http\Controllers\KaprodiKuisionerController;
use App\Http\Controllers\DosenKuisionerController;
use App\Http\Controllers\JawabanKuisionerController;
use App\Http\Controllers\KaprodiPlotingController;
use App\Http\Controllers\DekanPlotingController;
use App\Http\Controllers\DekanApprovalController;
use App\Http\Controllers\Wr1ApprovalController;
use App\Http\Controllers\SKController;
use App\Http\Controllers\DekanLaporanController;
use App\Http\Controllers\Wr1LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth default
Auth::routes();

Route::middleware(['auth'])->group(function () {

    /* ======================
       HOME REDIRECT
    ====================== */
    Route::get('/home', function () {
        return redirect()->route('dashboard.role', 'akademik');
    })->name('home');

    /* ======================
       DASHBOARD MULTI ROLE
    ====================== */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/{role}', [DashboardController::class, 'showByRole'])
        ->where('role', 'akademik|kaprodi|dekan|wr1|dosen')
        ->name('dashboard.role');

    /* ======================
       MASTER DATA
    ====================== */
    Route::resource('matakuliah', MataKuliahController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('sk_mengajar', SkMengajarController::class)->only(['index', 'show', 'destroy']);
    Route::get('sk_mengajar/{id}/download', [SkMengajarController::class, 'download'])->name('sk_mengajar.download');

    /* ======================
       ROLE SWITCHER
    ====================== */
    Route::post('/switch-role', [RoleSwitchController::class, 'switch'])
        ->name('role.switch');

    Route::get('/switch-role/{role}', [RoleSwitchController::class, 'switch'])
        ->where('role', 'akademik|kaprodi|dekan|wr1|dosen')
        ->name('role.switch.get');

    /* ======================
       KAPRODI — PLOTTING DOSEN
    ====================== */
    Route::prefix('kaprodi')->group(function () {
        Route::get('/ploting', [KaprodiPlotingController::class, 'index'])
            ->name('kaprodi.ploting.index');

        Route::get('/ploting/create', [KaprodiPlotingController::class, 'create'])
            ->name('kaprodi.ploting.create');

        Route::post('/ploting', [KaprodiPlotingController::class, 'store'])
            ->name('kaprodi.ploting.store');

        Route::post('/ploting/draft', [KaprodiPlotingController::class, 'saveDraft'])
            ->name('kaprodi.ploting.save_draft');

        Route::delete('/ploting/{id}', [KaprodiPlotingController::class, 'destroy'])
            ->name('kaprodi.ploting.destroy');

        Route::get('/ploting/revisi', [KaprodiPlotingController::class, 'revisiIndex'])
            ->name('kaprodi.ploting.revisi.index');

        Route::post('/ploting/revisi/{id}', [KaprodiPlotingController::class, 'revisiUpdate'])
            ->name('kaprodi.ploting.revisi.update');
    });

    /* ======================
       DEKAN — VERIFIKASI PLOTTING
    ====================== */
    Route::prefix('dekan/ploting')->group(function () {
        Route::get('/', [DekanPlotingController::class, 'index'])
            ->name('dekan.ploting.index');

        Route::get('/{ploting}', [DekanPlotingController::class, 'show'])
            ->name('dekan.ploting.show');

        Route::post('/{ploting}/approve', [DekanPlotingController::class, 'approve'])
            ->name('dekan.ploting.approve');

        Route::post('/{ploting}/reject', [DekanPlotingController::class, 'reject'])
            ->name('dekan.ploting.reject');
    });

    /* ======================
       DEKAN — APPROVAL CENTER
    ====================== */
    Route::get('dekan/approval', [DekanApprovalController::class, 'index'])
        ->name('dekan.approval.index');


    /* ======================
   DEKAN — LAPORAN MONITORING
====================== */
    Route::get('/dekan/laporan', [DekanLaporanController::class, 'index'])
        ->name('dekan.laporan.index');


    /* ======================
       WR1 — FINAL APPROVAL
    ====================== */
    Route::prefix('wr1/approval')->group(function () {
        Route::get('/', [Wr1ApprovalController::class, 'index'])
            ->name('wr1.approval.index');

        Route::get('/{ploting}', [Wr1ApprovalController::class, 'show'])
            ->name('wr1.approval.show');

        Route::post('/{ploting}/approve', [Wr1ApprovalController::class, 'approve'])
            ->name('wr1.approval.approve');

        Route::post('/{ploting}/reject', [Wr1ApprovalController::class, 'reject'])
            ->name('wr1.approval.reject');
    });

    /* ======================
       WR1 — GENERATE SK 
    ====================== */
    Route::prefix('wr1/sk')->group(function () {
        Route::get('/', [SKController::class, 'index'])
            ->name('wr1.sk.index');

        Route::post('/store/{ploting}', [SKController::class, 'store'])
            ->name('wr1.sk.store');

        Route::get('/download/{sk}', [SKController::class, 'generateSK'])
            ->name('sk.generate');

        // Route untuk daftar SK yang sudah dibuat (WR1 view)
        Route::get('/list', [SKController::class, 'list'])->name('wr1.sk.list');
    });

    /* ======================
   WR1 — LAPORAN FINAL
====================== */
    Route::get('/wr1/laporan', [Wr1LaporanController::class, 'index'])
        ->name('wr1.laporan.index');


    /* ======================
       KUISONER KAPRODI
    ====================== */
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

    /* ======================
       KUISONER DOSEN
    ====================== */
    Route::prefix('dosen/kuisioner')->group(function () {
        Route::get('/', [DosenKuisionerController::class, 'index'])
            ->name('dosen.kuisioner.index');

        Route::post('/jawab', [JawabanKuisionerController::class, 'store'])
            ->name('dosen.kuisioner.jawab');
    });
});
