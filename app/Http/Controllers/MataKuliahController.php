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
        $request->validate([
            'kode_mk'   => 'required|unique:matakuliah',
            'nama_mk'   => 'required',
            'sks'       => 'required|numeric',
            'semester'  => 'required|numeric',
            'status'    => 'required'
        ]);

        MataKuliah::create($request->all());

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataKuliah $matakuliah)
    {
        return view('matakuliah.edit', compact('matakuliah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataKuliah $matakuliah)
    {
        $request->validate([
            'kode_mk'   => 'required|unique:matakuliah,kode_mk,' . $matakuliah->id,
            'nama_mk'   => 'required',
            'sks'       => 'required|numeric',
            'semester'  => 'required|numeric',
            'status'    => 'required'
        ]);

        $matakuliah->update($request->all());

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataKuliah $matakuliah)
    {
        $matakuliah->delete();

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}
