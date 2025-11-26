<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // Data dummy — bisa kamu ambil dari database nanti
        $jumlah_mk   = 24;
        $kelas_aktif = 12;
        $jumlah_sk   = 1;

        return view('home', compact('jumlah_mk', 'kelas_aktif', 'jumlah_sk'));
    }
}
