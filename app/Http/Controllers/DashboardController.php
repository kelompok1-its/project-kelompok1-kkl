<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('home', [
            'jumlah_mk' => 24,
            'kelas_aktif' => 12,
            'jumlah_sk' => 1
        ]);
    }
}
