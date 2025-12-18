<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ploting;
use App\Models\SuratKeputusan;
use Barryvdh\DomPDF\Facade\Pdf;

class SKController extends Controller
{
    /**
     * Halaman daftar ploting yang siap dibuat SK (WR1)
     */
    public function index()
    {
        $plotings = Ploting::where('status', 'disetujui_dekan')
            ->where('final_status', 'approved')
            ->get();

        return view('wr1.generate-sk.index', compact('plotings'));
    }

    /**
     * Simpan SK dari ploting
     */
    public function store($plotingId)
    {
        $ploting = Ploting::findOrFail($plotingId);

        $sk = SuratKeputusan::create([
            'ploting_id'    => $ploting->id,
            'nomor_sk'      => 'SK-' . now()->format('Ymd') . '-' . $ploting->id,
            'status_dekan'  => 'disetujui',
            'status_warek1' => 'disetujui',
        ]);

        return redirect()
            ->route('sk.generate', $sk->id)
            ->with('success', 'SK berhasil dibuat');
    }

    /**
     * Generate PDF SK
     */
    public function generateSK($id)
    {
        $sk = SuratKeputusan::findOrFail($id);

        if (
            $sk->status_dekan !== 'disetujui' ||
            $sk->status_warek1 !== 'disetujui'
        ) {
            abort(403, 'SK belum disetujui');
        }

        $pdf = Pdf::loadView('sk.template', compact('sk'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('SK_' . $sk->nomor_sk . '.pdf');
    }
}
