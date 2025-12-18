<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ploting;
use Illuminate\Support\Facades\Auth;

class DekanPlotingController extends Controller
{
    public function __construct()
    {
        // Pastikan hanya user dengan role 'dekan' yang dapat mengakses controller ini.
        // Jika proyekmu menggunakan session('current_role_slug') untuk switch role,
        // kita juga periksa itu supaya konsisten dengan layouts/app.blade.php.
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            $roleSlug = session('current_role_slug', null);

            $isDekan = false;
            if ($user && (isset($user->role) && $user->role === 'dekan')) {
                $isDekan = true;
            }
            if ($roleSlug === 'dekan') {
                $isDekan = true;
            }

            if (!$isDekan) {
                abort(403, 'Unauthorized.');
            }

            return $next($request);
        });
    }

    // Tampilkan daftar ploting untuk diverifikasi (default: pending)
    public function index(Request $request)
    {
        $query = Ploting::with(['dosen', 'matakuliah', 'kelas', 'approver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'pending');
        }

        if ($request->filled('tahun_akademik')) {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }

        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        $plotings = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('dekan.ploting.index', compact('plotings'));
    }

    // Detail ploting
    public function show(Ploting $ploting)
    {
        $ploting->load(['dosen', 'matakuliah', 'kelas', 'approver']);
        return view('dekan.ploting.show', compact('ploting'));
    }

    // Approve (setujui)
    public function approve(Request $request, Ploting $ploting)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:1000',
        ]);

        if ($ploting->status === 'approved') {
            return redirect()->back()->with('info', 'Ploting sudah disetujui.');
        }

        $ploting->status = 'approved';
        $ploting->approved_by = Auth::id();
        $ploting->approved_at = now();
        $ploting->remarks = $request->remarks;
        $ploting->save();

        return redirect()->route('dekan.ploting.index')->with('success', 'Ploting disetujui.');
    }

    // Reject (tolak)
    public function reject(Request $request, Ploting $ploting)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $ploting->status = 'rejected';
        $ploting->approved_by = Auth::id();
        $ploting->approved_at = now();
        $ploting->remarks = $request->remarks;
        $ploting->save();

        return redirect()->route('dekan.ploting.index')->with('success', 'Ploting ditolak dan dikembalikan ke Kaprodi.');
    }
}
