<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    // Tampilkan semua data matakuliah
    public function index()
    {
        $matakuliah = Matakuliah::all();
        return view('matakuliah.index', compact('matakuliah'));
    }

    // Form tambah matakuliah baru
    public function create()
    {
        return view('matakuliah.create');
    }

    // Simpan data matakuliah
    public function store(Request $request)
    {
        $request->validate([
            'kode_mk'    => 'required|unique:matakuliah',
            'nama_mk'    => 'required',
            'sks'        => 'required|numeric',
            'kelas'      => 'required',
            'kurikulum'  => 'required',
            'fakultas'   => 'required',
            'prodi'      => 'required',
            'kode_prodi' => 'required',
            'status'     => 'required'
        ]);

        // Mass assignment
        Matakuliah::create($request->all());

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data berhasil ditambahkan!');
    }

    // Form edit matakuliah
    public function edit(Matakuliah $matakuliah)
    {
        return view('matakuliah.edit', compact('matakuliah'));
    }

    // Update data matakuliah
    public function update(Request $request, Matakuliah $matakuliah)
    {
        $request->validate([
            'kode_mk'    => 'required|unique:matakuliah,kode_mk,' . $matakuliah->id,
            'nama_mk'    => 'required',
            'sks'        => 'required|numeric',
            'kelas'      => 'required',
            'kurikulum'  => 'required',
            'fakultas'   => 'required',
            'prodi'      => 'required',
            'kode_prodi' => 'required',
            'status'     => 'required'
        ]);

        $matakuliah->update($request->all());

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data berhasil diperbarui!');
    }

    // Hapus data matakuliah
    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}
