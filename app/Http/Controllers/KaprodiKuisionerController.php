<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertanyaanKuisioner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KaprodiKuisionerController extends Controller
{
    // Tampilkan daftar kuisioner (group by judul)
    public function index()
    {
        $kuisioner = PertanyaanKuisioner::select(
            'judul',
            DB::raw('COUNT(*) as total'),
            DB::raw('MAX(created_at) as last_created_at')
        )
            ->groupBy('judul')
            ->orderByDesc('last_created_at')
            ->get();

        return view('kaprodi.kuisioner.index', compact('kuisioner'));
    }

    // Form buat kuisioner (sudah ada view create di repo)
    public function create()
    {
        return view('kaprodi.kuisioner.create');
    }

    // Simpan pertanyaan kuisioner (multiple pertanyaan untuk satu judul)
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
                'pertanyaan' => $q,
                'created_by' => Auth::id() ?? 0
            ]);
        }

        return redirect()
            ->route('kaprodi.kuisioner.index')
            ->with('success', 'Kuisioner berhasil dibuat.');
    }

    // Lihat hasil kuisioner (opsional filter by judul ?judul=...)
    public function hasil(Request $request)
    {
        // eager load jawaban dan relasi dosen (jika relasi dosen ada di model JawabanKuisioner)
        $query = PertanyaanKuisioner::with(['jawaban.dosen']);

        if ($request->filled('judul')) {
            $query->where('judul', $request->judul);
        }

        $hasil = $query->get();

        // daftar judul untuk dropdown filter
        $juduls = PertanyaanKuisioner::select('judul')->distinct()->orderBy('judul')->pluck('judul');

        return view('kaprodi.kuisioner.hasil', compact('hasil', 'juduls'));
    }
}
