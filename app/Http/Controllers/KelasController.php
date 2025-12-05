<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     * Also show the total count (Jumlah Kelas).
     */
    public function index(Request $request)
    {
        $query = Kelas::query();

        if ($search = $request->query('q')) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('kode', 'like', "%{$search}%");
        }

        $kelas = $query->orderBy('nama')->paginate(12)->withQueryString();

        $data = [
            'jumlah_kelas' => Kelas::count(),
            'kelas' => $kelas,
        ];

        return view('kelas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kelas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'jumlah_kelas' => 'required|integer|min:1',
            'nama_kelas' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
            'semester' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        Kelas::create($data);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        return view('kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        return view('kelas.edit', compact('kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $data = $request->validate([
            'kode' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'jumlah_kelas' => 'required|integer|min:1',
            'nama_kelas' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
            'semester' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        $kelas->update($data);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
