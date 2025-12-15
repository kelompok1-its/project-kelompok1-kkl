<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ploting;
use App\Models\User;
use App\Models\MataKuliah;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class KaprodiPlotingController extends Controller
{
    public function index(Request $request)
    {
        $query = Ploting::with(['dosen', 'matakuliah', 'kelas']);

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('tahun_akademik')) {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }
        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }
        if ($request->filled('matakuliah_id')) {
            $query->where('matakuliah_id', $request->matakuliah_id);
        }

        $plotings = $query->orderBy('created_at', 'desc')->paginate(25);

        $dosens = User::where('role', 'dosen')->get();
        $matakuliahs = class_exists(MataKuliah::class) ? MataKuliah::all() : collect();

        return view('kaprodi.ploting.index', compact('plotings', 'dosens', 'matakuliahs'));
    }

    public function create()
    {
        $dosens = User::where('role', 'dosen')->get();
        $matakuliahs = class_exists(MataKuliah::class) ? MataKuliah::all() : collect();
        $kelas = class_exists(Kelas::class) ? Kelas::all() : collect();

        return view('kaprodi.ploting.create', compact('dosens', 'matakuliahs', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|array',
            'dosen_id.*' => ['required', 'integer', Rule::exists('users', 'id')],
            'matakuliah_id' => 'required|integer',
            'kelas_id' => 'nullable|integer',
            'semester' => 'nullable|string',
            'tahun_akademik' => 'nullable|string',
        ]);

        $saved = 0;
        foreach ($request->dosen_id as $dosenId) {
            $exists = Ploting::where('dosen_id', $dosenId)
                ->where('matakuliah_id', $request->matakuliah_id)
                ->when($request->kelas_id, function ($q) use ($request) {
                    return $q->where('kelas_id', $request->kelas_id);
                })
                ->when($request->semester, function ($q) use ($request) {
                    return $q->where('semester', $request->semester);
                })
                ->when($request->tahun_akademik, function ($q) use ($request) {
                    return $q->where('tahun_akademik', $request->tahun_akademik);
                })
                ->exists();

            if ($exists) continue;

            Ploting::create([
                'dosen_id' => $dosenId,
                'matakuliah_id' => $request->matakuliah_id,
                'kelas_id' => $request->kelas_id,
                'semester' => $request->semester,
                'tahun_akademik' => $request->tahun_akademik,
                'created_by' => Auth::id(),
            ]);

            $saved++;
        }

        return redirect()->route('kaprodi.ploting.index')
            ->with('success', "{$saved} dosen berhasil diploting.");
    }

    public function destroy(Ploting $ploting)
    {
        $ploting->delete();
        return redirect()->route('kaprodi.ploting.index')->with('success', 'Ploting berhasil dihapus.');
    }
}
