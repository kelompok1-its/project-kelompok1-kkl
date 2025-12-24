<?php

namespace App\Http\Controllers;

use App\Models\Ploting;
use Illuminate\Support\Facades\Auth;

class Wr1LaporanController extends Controller
{
    public function __construct()
    {
        // Hanya WR1 yang boleh akses
        $this->middleware(function ($request, $next) {
            if (session('current_role_slug') !== 'wr1') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    /**
     * LAPORAN FINAL PLOTTING WR1
     */
    public function index()
    {
        $plotings = Ploting::with(['prodi', 'matakuliah', 'dosen', 'kelas'])
            ->whereNotNull('final_status')
            ->orderByDesc('final_at')
            ->get();

        return view('wr1.laporan.index', compact('plotings'));
    }
}
