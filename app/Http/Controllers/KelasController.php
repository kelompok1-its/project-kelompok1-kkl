<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        // Ambil data matakuliah untuk ditampilkan sebagai "kelas"
        $kelas = Matakuliah::when($search, function ($q) use ($search) {
            $q->where('kelas', 'like', "%$search%")
              ->orWhere('kode_mk', 'like', "%$search%")
              ->orWhere('nama_mk', 'like', "%$search%");
        })->get();

        return view('kelas.index', compact('kelas', 'search'));
    }

    public function edit($id)
    {
        // sebenarnya kamu mengedit data matakuliah, bukan tabel kelas.
        $kelas = Matakuliah::findOrFail($id);
        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas' => 'required',
            'kode_mk' => 'required',
            'nama_mk' => 'required'
        ]);

        $kelas = Matakuliah::findOrFail($id);

        $kelas->update([
            'kelas' => $request->kelas,
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Matakuliah::findOrFail($id)->delete();

        return redirect()->route('kelas.index')->with('success', 'Data berhasil dihapus!');
    }
}
