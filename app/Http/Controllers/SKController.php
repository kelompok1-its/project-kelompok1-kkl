<?php

namespace App\Http\Controllers;

use App\Models\Ploting;
use App\Models\SuratKeputusan;
use Barryvdh\DomPDF\Facade\Pdf;

class SKController extends Controller
{
    public function index()
    {
        $plotings = Ploting::where('final_status', 'approved')
            ->whereDoesntHave('suratKeputusan')
            ->get();

        return view('wr1.generate-sk.index', compact('plotings'));
    }

    public function store($plotingId)
    {
        $ploting = Ploting::findOrFail($plotingId);

        $sk = SuratKeputusan::create([
            'ploting_id' => $ploting->id,
            'nomor_sk'   => 'SK-' . date('Ymd') . '-' . $ploting->id,
            'status_dekan' => 'disetujui',
            'status_warek1'=> 'disetujui',
        ]);

        return redirect()->route('sk.generate', $sk->id);
    }

    public function generateSK($id)
    {
        $sk = SuratKeputusan::findOrFail($id);

        $pdf = Pdf::loadView('sk.template', compact('sk'));
        return $pdf->download('SK_'.$sk->nomor_sk.'.pdf');
    }
}
