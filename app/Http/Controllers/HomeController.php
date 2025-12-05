<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Pastikan /home hanya redirect ke dashboard (yang akan meng-handle auto-redirect per-role)
        return redirect()->route('dashboard');
    }
}
