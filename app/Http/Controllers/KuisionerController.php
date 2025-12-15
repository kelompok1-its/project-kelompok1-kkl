<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertanyaanKuisioner;
use App\Models\JawabanKuisioner;
use Illuminate\Support\Facades\Auth;

class KuisionerController extends Controller
{
    /**
     * ==============================
     *  KAPRODI – BUAT KUISIONER
     * ==============================
     */
    public function create()
    {
        return view('kaprodi.kuisioner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'pertanyaan' => 'required|array',
            'pertanyaan.*' => 'required|string'
        ]);

        foreach ($request->pertanyaan as $q) {
            PertanyaanKuisioner::create([
                'judul' => $request->judul,
                'pertanyaan' => $q
            ]);
        }

        return redirect()
            ->route('kaprodi.kuisioner.create')
            ->with('success', 'Kuisioner berhasil dibuat.');
    }


    /**
     * ==============================
     *  KAPRODI – LIHAT HASIL KUISIONER
     * ==============================
     */
    public function hasil()
    {
        $hasil = PertanyaanKuisioner::with('jawaban')->get();

        return view('kaprodi.kuisioner.hasil', compact('hasil'));
    }


    /**
     * ==============================
     *  DOSEN – LIHAT KUISIONER
     * ==============================
     */
    public function dosenIndex()
    {
        $pertanyaan = PertanyaanKuisioner::all();

        return view('dosen.kuisioner.isi', compact('pertanyaan'));
    }


    /**
     * ==============================
     *  DOSEN – KIRIM JAWABAN KUISIONER
     * ==============================
     */
    public function submitJawaban(Request $request)
    {
        $request->validate([
            'jawaban' => 'required|array'
        ]);

        foreach ($request->jawaban as $pertanyaan_id => $isi) {
            JawabanKuisioner::create([
                'pertanyaan_id' => $pertanyaan_id,
                'dosen_id' => Auth::id(),  // simpan siapa dosennya
                'jawaban' => $isi
            ]);
        }

        return redirect()
            ->route('dosen.kuisioner')
            ->with('success', 'Jawaban kuisioner berhasil dikirim.');
    }
}
