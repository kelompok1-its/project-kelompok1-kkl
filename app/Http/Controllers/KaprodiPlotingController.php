<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ploting;
use App\Models\MataKuliah;
use App\Models\User;

class KaprodiPlotingController extends Controller
{
    /**
     * =========================
     * HALAMAN DAFTAR PLOTTING
     * =========================
     */
    public function index(Request $request)
    {
        // ambil semua dosen (untuk filter)
        $dosens = User::where('role', 'dosen')
            ->orderBy('name')
            ->get();

        // ambil semua mata kuliah (karena tidak ada prodi_id)
        $matakuliahs = MataKuliah::orderBy('kode_mk')->get();

        // query ploting
        $query = Ploting::with(['dosen', 'matakuliah'])
            ->orderBy('created_at', 'desc');

        // FILTER OPTIONAL
        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        if ($request->filled('matakuliah_id')) {
            $query->where('matakuliah_id', $request->matakuliah_id);
        }

        if ($request->filled('tahun_akademik')) {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }

        $plotings = $query->paginate(10);

        return view('kaprodi.ploting.index', compact(
            'plotings',
            'dosens',
            'matakuliahs'
        ));
    }

    /**
     * =========================
     * FORM TAMBAH PLOTTING
     * =========================
     */
    public function create()
    {
        $matakuliahs = MataKuliah::orderBy('kode_mk')->get();

        $dosens = User::where('role', 'dosen')
            ->orderBy('name')
            ->get();

        return view('kaprodi.ploting.create', compact(
            'matakuliahs',
            'dosens'
        ));
    }

    /**
     * =========================
     * SIMPAN PLOTTING (KIRIM KE DEKAN)
     * =========================
     */
    public function store(Request $request)
    {
        $request->validate([
            'matakuliah_id'  => 'required',
            'dosen_id'       => 'required',
            'kelas_id'       => 'required',
            'semester'       => 'required',
            'tahun_akademik' => 'required',
        ]);

        Ploting::create([
            'matakuliah_id'  => $request->matakuliah_id,
            'dosen_id'       => $request->dosen_id,
            'kelas_id'       => $request->kelas_id,
            'semester'       => $request->semester,
            'tahun_akademik' => $request->tahun_akademik,
            'created_by'     => Auth::id(),
            'status'         => 'pending', // menunggu Dekan
            'prodi_id'       => 1, // sementara HARDCODE biar aman
        ]);

        return redirect()
            ->route('ploting.index')
            ->with('success', 'Ploting berhasil dikirim ke Dekan');
    }

    /**
     * =========================
     * SIMPAN SEBAGAI DRAFT
     * =========================
     */
    public function saveDraft(Request $request)
    {
        $request->validate([
            'matakuliah_id' => 'required',
            'dosen_id'      => 'required',
            'kelas_id'      => 'required',
        ]);

        Ploting::create([
            'matakuliah_id' => $request->matakuliah_id,
            'dosen_id'      => $request->dosen_id,
            'kelas_id'      => $request->kelas_id,
            'created_by'    => Auth::id(),
            'status'        => 'draft',
            'prodi_id'      => 1, // sementara
        ]);

        return response()->json([
            'message' => 'Draft berhasil disimpan'
        ]);
    }

    /**
     * =========================
     * HAPUS PLOTTING
     * =========================
     */
    public function destroy($id)
    {
        $ploting = Ploting::findOrFail($id);

        if (!in_array($ploting->status, ['draft', 'pending'])) {
            return back()->with('error', 'Ploting tidak bisa dihapus');
        }

        $ploting->delete();

        return back()->with('success', 'Ploting berhasil dihapus');
    }
}
