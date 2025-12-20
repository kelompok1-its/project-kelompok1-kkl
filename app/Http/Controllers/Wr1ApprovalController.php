<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Ploting;
use App\Models\SuratKeputusan;

class Wr1ApprovalController extends Controller
{
    public function __construct()
    {
        // Hanya role WR1 yang boleh akses
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            $roleSlug = session('current_role_slug');

            if (
                ! $user ||
                ($user->role !== 'wr1' && $roleSlug !== 'wr1')
            ) {
                abort(403, 'Unauthorized.');
            }

            return $next($request);
        });
    }

    /**
     * Daftar ploting yang:
     * - sudah disetujui Dekan
     * - belum final approval WR1
     */
    public function index(Request $request)
    {
        if (!Schema::hasColumn('plotings', 'final_status')) {
            abort(500, 'Kolom final_status belum tersedia.');
        }

        $plotings = Ploting::with(['dosen', 'matakuliah', 'kelas', 'prodi'])
            ->where('status', 'approved') // approved oleh Dekan
            ->where(function ($q) {
                $q->whereNull('final_status')
                  ->orWhere('final_status', 'pending');
            })
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('wr1.approval.index', compact('plotings'));
    }

    /**
     * Detail ploting
     */
    public function show(Ploting $ploting)
    {
        $ploting->load([
            'dosen',
            'matakuliah',
            'kelas',
            'prodi',
            'approver',
            'approverFinal'
        ]);

        return view('wr1.approval.show', compact('ploting'));
    }

    /**
     * FINAL APPROVAL WR1
     * + AUTO CREATE SK
     * + AUTO GENERATE PDF
     */
    public function approve(Request $request, Ploting $ploting)
    {
        $request->validate([
            'final_remarks' => 'nullable|string|max:1000',
        ]);

        if ($ploting->final_status === 'approved') {
            return back()->with('info', 'Ploting sudah final disetujui.');
        }

        /* ======================
           FINAL APPROVAL WR1
        ======================= */
        $ploting->update([
            'final_status'   => 'approved',
            'final_by'       => Auth::id(),
            'final_at'       => now(),
            'final_remarks'  => $request->final_remarks,
            'status'         => 'final_approved',
        ]);

        /* ======================
           CREATE / GET SK
        ======================= */
        $sk = SuratKeputusan::firstOrCreate(
            ['ploting_id' => $ploting->id],
            [
                'nomor_sk'      => 'SK-' . now()->format('Y') . '-' . str_pad($ploting->id, 4, '0', STR_PAD_LEFT),
                'judul_sk'      => 'Surat Keputusan Mengajar',
                'isi_sk'        => "Menetapkan dosen {$ploting->dosen->name} sebagai pengampu mata kuliah {$ploting->matakuliah->nama}.",
                'tanggal_sk'    => now(),
                'status_dekan'  => 'disetujui',
                'status_warek1' => 'disetujui',
                'nama_warek1'   => Auth::user()->name,
                'nip_warek1'    => Auth::user()->nip ?? '-',
            ]
        );

        /* ======================
           REDIRECT GENERATE SK
        ======================= */
        return redirect()
            ->route('sk.generate', $sk->id)
            ->with('success', 'Ploting disetujui & SK berhasil dibuat.');
    }

    /**
     * FINAL REJECT WR1
     * Dikembalikan ke Dekan
     */
    public function reject(Request $request, Ploting $ploting)
    {
        $request->validate([
            'final_remarks' => 'required|string|max:1000',
        ]);

        $ploting->update([
            'final_status'  => 'rejected',
            'final_by'      => Auth::id(),
            'final_at'      => now(),
            'final_remarks' => $request->final_remarks,
            'status'        => 'rejected_by_wr1',
        ]);

        return redirect()
            ->route('wr1.approval.index')
            ->with('success', 'Ploting ditolak dan dikembalikan ke Dekan.');
    }
}
