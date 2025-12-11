<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    /**
     * Tampilkan list mata kuliah.
     */
    public function index()
    {
        $matakuliah = Matakuliah::orderBy('kode_mk')->get();

        return view('akademik.matakuliah.index', compact('matakuliah'));
    }

    /**
     * Form tambah.
     */
    public function create()
    {
        return view('akademik.matakuliah.create');
    }

    /**
     * Simpan MK baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk'    => 'required|unique:matakuliah,kode_mk',
            'nama_mk'    => 'required|string',
            'sks'        => 'required|numeric|min:1',
            'kelas'      => 'required|string',
            'kurikulum'  => 'required|string',
            'fakultas'   => 'required|string',
            'prodi'      => 'required|string',
            'kode_prodi' => 'required|string',
            'status'     => 'required|string',
        ]);

        Matakuliah::create($validated);

        return redirect()->route('matakuliah.index')->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    /**
     * Halaman edit MK.
     */
    public function edit(Matakuliah $matakuliah)
    {
        return view('akademik.matakuliah.edit', compact('matakuliah'));
    }

    /**
     * Update MK.
     */
    public function update(Request $request, Matakuliah $matakuliah)
    {
        $validated = $request->validate([
            'kode_mk'    => 'required|unique:matakuliah,kode_mk,' . $matakuliah->id,
            'nama_mk'    => 'required|string',
            'sks'        => 'required|numeric|min:1',
            'kelas'      => 'required|string',
            'kurikulum'  => 'required|string',
            'fakultas'   => 'required|string',
            'prodi'      => 'required|string',
            'kode_prodi' => 'required|string',
            'status'     => 'required|string',
        ]);

        $matakuliah->update($validated);

        return redirect()->route('matakuliah.index')->with('success', 'Data mata kuliah berhasil diperbarui!');
    }

    /**
     * Hapus MK.
     */
    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();

        return redirect()->route('matakuliah.index')->with('success', 'Mata kuliah berhasil dihapus!');
    }
}
