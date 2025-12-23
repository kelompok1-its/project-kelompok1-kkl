<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ploting;
use App\Models\MataKuliah;
use App\Models\User;

class KaprodiPlotingController extends Controller
{
    public function index(Request $request)
    {
        $dosens = User::where('role', 'dosen')->orderBy('name')->get();
        $matakuliahs = MataKuliah::orderBy('kode_mk')->get();
        $query = Ploting::with(['dosen', 'matakuliah'])->orderBy('created_at', 'desc');

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

    public function create()
    {
        // Ambil semua mata kuliah
        $matakuliahs = MataKuliah::orderBy('kode_mk')->get();

        // Ambil semua dosen
        $dosens = User::where('role', 'dosen')
            ->orderBy('name')
            ->get();

        // Ambil data existing ploting dengan status 'draft', agar bisa ditampilkan untuk pre-fill
        $existing = Ploting::where('status', 'draft')->get();

        // Kirim data ke view
        return view('kaprodi.ploting.create', compact(
            'matakuliahs', // Data mata kuliah
            'dosens',      // Data dosen
            'existing'     // Data existing ploting dengan status draft
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$request->has('plotings')) {
            return back()->with('error', 'Tidak ada data ploting yang dikirim.');
        }

        $count = 0;

        foreach ($request->plotings as $row) {

            // hanya proses baris yang dicentang
            if (!isset($row['selected'])) {
                continue;
            }

            // validasi minimal
            if (
                empty($row['matakuliah_id']) ||
                empty($row['dosen_id']) ||
                empty($row['kelas'])
            ) {
                continue;
            }

            Ploting::create([
                'matakuliah_id'  => $row['matakuliah_id'],
                'dosen_id'       => $row['dosen_id'],
                'kelas_id'       => $row['kelas'], // STRING (5SA)
                'semester'       => 'Genap',        // bisa kamu ganti
                'tahun_akademik' => '2023',
                'created_by'     => $user->id,
                'prodi_id'       => $user->prodi_id ?? 1,
                'status'         => 'pending', // ke DEKAN
            ]);

            $count++;
        }

        if ($count === 0) {
            return back()->with('error', 'Tidak ada baris valid yang disubmit.');
        }

        return redirect()
            ->route('kaprodi.ploting.index')
            ->with('success', "$count ploting berhasil dikirim ke Dekan.");
    }

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
            'prodi_id'      => 1,
        ]);

        return response()->json([
            'message' => 'Draft berhasil disimpan'
        ]);
    }

    public function destroy($id)
    {
        $ploting = Ploting::findOrFail($id);

        if (!in_array($ploting->status, ['draft', 'pending'])) {
            return back()->with('error', 'Ploting tidak bisa dihapus');
        }

        $ploting->delete();

        return back()->with('success', 'Ploting berhasil dihapus');
    }

    /**
     * =========================
     * REVISI PLOTTING
     * =========================
     */

    // Tampilkan daftar ploting yang butuh revisi
    public function revisiIndex()
    {
        // Ambil semua ploting dengan status revisi
        $plotings = Ploting::where('status', 'revisi')
            ->with(['dosen', 'matakuliah'])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Kirim ke view
        return view('kaprodi.ploting.revisi.index', compact('plotings'));
    }

    // Tampilkan form revisi untuk ploting tertentu berdasarkan ID
    public function revisiEdit($id)
    {
        $ploting = Ploting::findOrFail($id);

        if ($ploting->status !== 'revisi') {
            return redirect()->route('kaprodi.ploting.revisi.index')->with('error', 'Plotting ini tidak dapat direvisi.');
        }

        $dosens = User::where('role', 'dosen')->orderBy('name')->get();

        return view('kaprodi.ploting.revisi.edit', compact('ploting', 'dosens'));
    }

    // Simpan hasil revisi ploting
    public function revisiUpdate(Request $request, $id)
    {
        $request->validate([
            'dosen_id' => 'required|exists:users,id',
        ]);

        $ploting = Ploting::findOrFail($id);

        if ($ploting->status !== 'revisi') {
            return redirect()->route('kaprodi.ploting.revisi.index')->with('error', 'Plotting ini tidak dapat direvisi.');
        }

        $ploting->update([
            'dosen_id' => $request->dosen_id,
            'status' => 'pending', // Status dikembalikan ke pending
        ]);

        return redirect()->route('kaprodi.ploting.revisi.index')->with('success', 'Ploting berhasil direvisi.');
    }
}
