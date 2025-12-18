<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Ploting;

class Wr1ApprovalController extends Controller
{
    public function __construct()
    {
        // middleware inline: hanya user role 'wr1' atau session role 'wr1'
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            $roleSlug = session('current_role_slug', null);

            $isWr1 = false;
            if ($user && (isset($user->role) && $user->role === 'wr1')) {
                $isWr1 = true;
            }
            if ($roleSlug === 'wr1') {
                $isWr1 = true;
            }

            if (! $isWr1) {
                abort(403, 'Unauthorized.');
            }

            return $next($request);
        });
    }

    /**
     * List plotings yang sudah disetujui Dekan (status = 'approved') dan menunggu WR1 (final_status IS NULL or 'pending').
     */
    public function index(Request $request)
    {
        // Pastikan kolom final_status ada
        if (! Schema::hasColumn('plotings', 'final_status')) {
            abort(500, 'Kolom final_status belum tersedia. Jalankan migration WR1.');
        }

        $query = Ploting::with(['dosen', 'matakuliah', 'kelas', 'prodi', 'approver'])
            ->where('status', 'approved') // sudah disetujui Dekan
            ->where(function ($q) {
                $q->whereNull('final_status')->orWhere('final_status', 'pending');
            });

        // optional filter: fakultas/prodi jika perlu (WR1 biasanya lihat semua)
        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->prodi_id);
        }

        $plotings = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('wr1.approval.index', compact('plotings'));
    }

    /**
     * Show detail ploting
     */
    public function show(Ploting $ploting)
    {
        $ploting->load(['dosen','matakuliah','kelas','prodi','approver','approverFinal']);
        return view('wr1.approval.show', compact('ploting'));
    }

    /**
     * Final approved by WR1
     */
    public function approve(Request $request, Ploting $ploting)
    {
        $this->validate($request, [
            'final_remarks' => 'nullable|string|max:1000',
        ]);

        if ($ploting->final_status === 'approved') {
            return redirect()->back()->with('info', 'Sudah final disetujui.');
        }

        $ploting->final_status = 'approved';
        $ploting->final_by = Auth::id();
        $ploting->final_at = now();
        $ploting->final_remarks = $request->input('final_remarks');
        // optional: set overall status untuk menandakan final approval
        $ploting->status = 'final_approved';
        $ploting->save();

        return redirect()->route('wr1.approval.index')->with('success', 'Ploting berhasil disetujui secara final.');
    }

    /**
     * Final reject by WR1 — dikembalikan ke Dekan (atau ke Dekan sebagai review)
     */
    public function reject(Request $request, Ploting $ploting)
    {
        $this->validate($request, [
            'final_remarks' => 'required|string|max:1000',
        ]);

        $ploting->final_status = 'rejected';
        $ploting->final_by = Auth::id();
        $ploting->final_at = now();
        $ploting->final_remarks = $request->input('final_remarks');

        // kembalikan status agar Dekan / Kaprodi bisa proses ulang; gunakan 'rejected_by_wr1' agar traceable
        $ploting->status = 'rejected_by_wr1';
        $ploting->save();

        // (opsional) Notifikasi: kamu bisa mengirim notification ke Dekan/Kaprodi di sini

        return redirect()->route('wr1.approval.index')->with('success', 'Ploting ditolak dan dikembalikan ke Dekan.');
    }
}