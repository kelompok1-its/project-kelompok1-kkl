<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleSwitchController extends Controller
{
    public function __construct()
    {
        // jika ingin proteksi di controller, uncomment:
        // $this->middleware('auth');
    }

    /**
     * Switch current session role.
     * Accepts:
     *  - POST /switch-role  (body: role)  -> request only
     *  - GET  /switch-role/{role}         -> route param
     *
     * Method signature is Request first and $role optional to avoid "Too few arguments".
     */
    public function switch(Request $request, $role = null)
    {
        // jika route GET memanggil dengan role sebagai param, Laravel mengisi $role.
        // jika POST, role akan diambil dari $request->input('role').
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil role dari route param (jika ada) atau body
        $role = $role ?? $request->input('role');

        $allowed = [
            'akademik' => 'Akademik',
            'kaprodi'  => 'Kaprodi',
            'dekan'    => 'Dekan',
            'wr1'      => 'Wakil Rektor I',
            'dosen'    => 'Dosen',
        ];

        $role = strtolower($role ?? '');

        if (! array_key_exists($role, $allowed)) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Role tidak valid'], 422);
            }
            abort(404);
        }

        // Optional: cek otorisasi tambahan jika perlu
        // if ($role === 'wr1' && ! Auth::user()->is_admin) { abort(403); }

        // Simpan di session
        session([
            'current_role' => $allowed[$role],
            'current_role_slug' => $role,
        ]);

        $request->session()->flash('status', 'Berhasil mengganti aktor ke: ' . $allowed[$role]);

        // Redirect ke dashboard per role
        return redirect()->route('dashboard.role', ['role' => $role]);
    }
}
