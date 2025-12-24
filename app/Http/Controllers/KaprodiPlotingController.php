<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ploting;
use App\Models\MataKuliah;
use App\Models\User;
use App\Models\Kelas;

class KaprodiPlotingController extends Controller
{
    public function index(Request $request)
    {
        $dosens = User::where('role', 'dosen')->orderBy('name')->get();
        $matakuliahs = MataKuliah::orderBy('kode_mk')->get();

        // Eager-load relasi termasuk kelas supaya nama kelas bisa ditampilkan tanpa N+1
        $query = Ploting::with(['dosen', 'matakuliah', 'kelas'])->orderBy('created_at', 'desc');

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
        $matakuliahs = MataKuliah::orderBy('kode_mk')->get();
        $dosens = User::where('role', 'dosen')->orderBy('name')->get();
        // Ambil daftar kelas untuk form (jika ingin ubah ke select)
        $kelasList = Kelas::orderBy('nama')->get();

        // Ambil data existing ploting dengan status 'draft', agar bisa ditampilkan untuk pre-fill
        $existing = Ploting::where('status', 'draft')->get();

        return view('kaprodi.ploting.create', compact(
            'matakuliahs',
            'dosens',
            'existing',
            'kelasList'
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

            if (!isset($row['selected'])) {
                continue;
            }

            if (
                empty($row['matakuliah_id']) ||
                empty($row['dosen_id']) ||
                empty($row['kelas'])
            ) {
                continue;
            }

            // Catatan: form lama mungkin mengirim kelas sebagai string (mis. "5SA") atau sebagai id.
            // Jika nilai numeric dianggap id kelas, simpan ke kelas_id; kalau tidak, simpan ke kolom kelas (string)
            $kelasId = null;
            $kelasString = null;

            if (is_numeric($row['kelas'])) {
                $kelasId = intval($row['kelas']);
            } else {
                $kelasString = $row['kelas'];
            }

            Ploting::create([
                'matakuliah_id'  => $row['matakuliah_id'],
                'dosen_id'       => $row['dosen_id'],
                // Simpan preferensi: jika ada kelas_id simpan ke kelas_id, else simpan string ke kolom kelas
                'kelas_id'       => $kelasId,
                'kelas'          => $kelasString,
                'semester'       => 'Genap',
                'tahun_akademik' => '2023',
                'created_by'     => $user->id,
                'prodi_id'       => $user->prodi_id ?? 1,
                'status'         => 'pending',
            ]);

            $count++;
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

        // Izinkan penghapusan ketika masih draft/pending,
        // atau ketika sedang direvisi (status = 'revisi') atau WR1 sudah menolak (final_status = 'rejected')
        $canDelete = in_array($ploting->status, ['draft', 'pending', 'revisi']) ||
            in_array($ploting->final_status, ['rejected', 'ditolak']);

        if (! $canDelete) {
            return back()->with('error', 'Ploting tidak bisa dihapus.');
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
        $plotings = Ploting::where(function ($q) {
            $q->where('status', 'revisi')
                ->orWhere('final_status', 'rejected')
                ->orWhere('final_status', 'ditolak');
        })
            ->with(['dosen', 'matakuliah', 'kelas'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $dosens = User::where('role', 'dosen')->orderBy('name')->get();

        return view('kaprodi.ploting.revisi.index', compact('plotings', 'dosens'));
    }

    public function revisiEdit($id)
    {
        $ploting = Ploting::findOrFail($id);

        if ($ploting->status !== 'revisi' && $ploting->final_status !== 'rejected' && $ploting->final_status !== 'ditolak') {
            return redirect()->route('kaprodi.ploting.revisi.index')->with('error', 'Plotting ini tidak dapat direvisi.');
        }

        $dosens = User::where('role', 'dosen')->orderBy('name')->get();

        return view('kaprodi.ploting.revisi.edit', compact('ploting', 'dosens'));
    }

    public function revisiUpdate(Request $request, $id)
    {
        $request->validate([
            'dosen_id' => 'required|exists:users,id',
        ]);

        $ploting = Ploting::findOrFail($id);

        if ($ploting->status !== 'revisi' && $ploting->final_status !== 'rejected' && $ploting->final_status !== 'ditolak') {
            return redirect()->route('kaprodi.ploting.revisi.index')->with('error', 'Plotting ini tidak dapat direvisi.');
        }

        $ploting->update([
            'dosen_id' => $request->dosen_id,
            'status' => 'pending', // Status dikembalikan ke pending
            'final_status' => null, // reset final_status setelah direvisi
            'final_remarks' => null,
        ]);

        return redirect()->route('kaprodi.ploting.revisi.index')->with('success', 'Ploting berhasil direvisi.');
    }
}
