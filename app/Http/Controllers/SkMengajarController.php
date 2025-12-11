<?php

namespace App\Http\Controllers;

use App\Models\SkMengajar;
use Illuminate\Http\Request;

class SkMengajarController extends Controller
{
    private $basePath = 'akademik.sk_mengajar.';

    public function index()
    {
        $sk_mengajar = SkMengajar::latest()->get();
        $jumlah_sk = SkMengajar::count();

        return view($this->basePath . 'index', compact('sk_mengajar', 'jumlah_sk'));
    }

    public function create()
    {
        return view($this->basePath . 'create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_sk' => 'required|unique:sk_mengajar',
            'tahun_akademik' => 'required',
            'semester' => 'required',
            'tanggal_terbit' => 'required|date',
            'dosen_nama' => 'required',
            'mata_kuliah' => 'required',
            'kelas' => 'required',
            'sks' => 'required|numeric',
            'status' => 'required'
        ]);

        SkMengajar::create($request->all());

        return redirect()->route('sk_mengajar.index')
            ->with('success', 'SK Mengajar berhasil ditambahkan!');
    }

    public function show(SkMengajar $skMengajar)
    {
        return view($this->basePath . 'show', compact('skMengajar'));
    }

    public function edit(SkMengajar $skMengajar)
    {
        return view($this->basePath . 'edit', compact('skMengajar'));
    }

    public function update(Request $request, SkMengajar $skMengajar)
    {
        $request->validate([
            'nomor_sk' => 'required|unique:sk_mengajar,nomor_sk,' . $skMengajar->id,
            'tahun_akademik' => 'required',
            'semester' => 'required',
            'tanggal_terbit' => 'required|date',
            'dosen_nama' => 'required',
            'mata_kuliah' => 'required',
            'kelas' => 'required',
            'sks' => 'required|numeric',
            'status' => 'required'
        ]);

        $skMengajar->update($request->all());

        return redirect()->route('sk_mengajar.index')
            ->with('success', 'SK Mengajar berhasil diperbarui!');
    }

    public function destroy(SkMengajar $skMengajar)
    {
        $skMengajar->delete();

        return redirect()->route('sk_mengajar.index')
            ->with('success', 'SK Mengajar berhasil dihapus!');
    }
}
