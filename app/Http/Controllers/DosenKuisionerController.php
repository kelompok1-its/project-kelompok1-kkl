<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertanyaanKuisioner;

class DosenKuisionerController extends Controller
{
    // Tampilkan form pengisian kuisioner untuk dosen
    public function index()
    {
        $pertanyaan = PertanyaanKuisioner::orderBy('created_at', 'desc')->get();
        return view('dosen.kuisioner.isi', compact('pertanyaan'));
    }
}
