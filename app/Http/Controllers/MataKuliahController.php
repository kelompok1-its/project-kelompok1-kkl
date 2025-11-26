<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil semua data matakuliah
        $matakuliah = MataKuliah::all();

        return view('matakuliah.index', compact('matakuliah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('matakuliah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_mk' => 'required|unique:matakuliah',
            'nama_mk' => 'required',
            'sks' => 'required|numeric',
            'semester' => 'required|numeric'
        ]);

        MataKuliah::create([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks,
            'semester' => $request->semester,
        ]);

        return redirect()->route('matakuliah.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $matakuliah = MataKuliah::findOrFail($id);

        return view('matakuliah.edit', compact('matakuliah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $matakuliah = MataKuliah::findOrFail($id);

        // Validasi input
        $request->validate([
            'kode_mk' => 'required|unique:matakuliah,kode_mk,' . $matakuliah->id,
            'nama_mk' => 'required',
            'sks' => 'required|numeric',
            'semester' => 'required|numeric'
        ]);

        $matakuliah->update([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks,
            'semester' => $request->semester,
        ]);

        return redirect()->route('matakuliah.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $matakuliah = MataKuliah::findOrFail($id);
        $matakuliah->delete();

        return redirect()->route('matakuliah.index')->with('success', 'Data berhasil dihapus!');
    }
}
