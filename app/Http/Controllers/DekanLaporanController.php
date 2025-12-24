<?php

namespace App\Http\Controllers;

use App\Models\Ploting;
use Illuminate\Support\Facades\Auth;

class DekanLaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (session('current_role_slug') !== 'dekan') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    /**
     * LAPORAN MONITORING PLOTTING (DEKAN)
     */
    public function index()
    {
        $plotings = Ploting::with([
                'prodi',
                'matakuliah',
                'dosen',
                'kelas',
                'approver',
                'approverFinal'
            ])
            ->orderByDesc('created_at')
            ->get();

        return view('dekan.laporan.index', compact('plotings'));
    }
}
