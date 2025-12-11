<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Menampilkan daftar kelas (data dari tabel matakuliah)
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $kelas = Matakuliah::when($search, function ($q) use ($search) {
            $q->where('kelas', 'like', "%$search%")
                ->orWhere('kode_mk', 'like', "%$search%")
                ->orWhere('nama_mk', 'like', "%$search%");
        })
            ->orderBy('kode_mk', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('akademik.kelas.index', compact('kelas', 'search'));
    }

    /**
     * Form Edit Kelas
     */
    public function edit($id)
    {
        $kelas = Matakuliah::findOrFail($id);
        return view('akademik.kelas.edit', compact('kelas'));
    }

    /**
     * Update data kelas
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas' => 'required|string',
        ]);

        $kelas = Matakuliah::findOrFail($id);

        $kelas->update([
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui!');
    }

    /**
     * Hapus kelas
     */
    public function destroy($id)
    {
        Matakuliah::findOrFail($id)->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus!');
    }
}
