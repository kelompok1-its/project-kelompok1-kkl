<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JawabanKuisioner;
use Illuminate\Support\Facades\Auth;

class JawabanKuisionerController extends Controller
{
    // Simpan jawaban dosen
    public function store(Request $request)
    {
        $request->validate([
            'jawaban' => 'required|array'
        ]);

        foreach ($request->jawaban as $pertanyaan_id => $isi) {
            if (is_null($isi) || trim($isi) === '') {
                continue; // skip kosong
            }

            JawabanKuisioner::create([
                'pertanyaan_id' => $pertanyaan_id,
                'dosen_id' => Auth::id(),
                'jawaban' => $isi
            ]);
        }

        return redirect()
            ->route('dosen.kuisioner.index')
            ->with('success', 'Jawaban kuisioner berhasil dikirim.');
    }
}
