<?php

namespace App\Http\Controllers;

use App\Models\Ploting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Wr1ApprovalController extends Controller
{
    public function index()
    {
        $plotings = Ploting::whereIn('status', ['approved', 'disetujui_dekan'])
            ->whereNull('final_status')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('wr1.approval.index', compact('plotings'));
    }

    public function show(Ploting $ploting)
    {
        $ploting->load(['dosen', 'matakuliah', 'kelas', 'approver', 'approverFinal']);
        return view('wr1.approval.show', compact('ploting'));
    }

    public function approve($id)
    {
        $ploting = Ploting::findOrFail($id);

        $ploting->update([
            'final_status' => 'approved',
            'final_by'     => Auth::id(),
            'final_at'     => now(),
        ]);

        return back()->with('success', 'Ploting disetujui WR1');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'final_remarks' => 'required'
        ]);

        $ploting = Ploting::findOrFail($id);

        // Penting: set final_status + ubah status utama jadi 'revisi' agar Kaprodi melihatnya
        $ploting->update([
            'final_status'  => 'rejected',
            'status'        => 'revisi',        // <-- kunci untuk muncul di Revisi Kaprodi
            'final_by'      => Auth::id(),
            'final_at'      => now(),
            'final_remarks' => $request->final_remarks,
        ]);

        return back()->with('error', 'Ploting ditolak WR1 dan dikirim kembali untuk revisi.');
    }
}
