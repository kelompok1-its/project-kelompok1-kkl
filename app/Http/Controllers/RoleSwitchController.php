<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleSwitchController extends Controller
{
    public function switch(Request $request, $role = null)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil role dari route param atau body
        $role = $role ?? $request->input('role');

        $allowed = [
            'akademik' => 'Akademik',
            'kaprodi'  => 'Kaprodi',
            'dekan'    => 'Dekan',
            'wr1'      => 'Wakil Rektor I',
            'dosen'    => 'Dosen',
        ];

        $role = strtolower($role ?? '');

        if (!array_key_exists($role, $allowed)) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Role tidak valid'], 422);
            }
            abort(404);
        }

        // Simpan di session
        session([
            'current_role' => $allowed[$role],
            'current_role_slug' => $role,
        ]);

        // IMPORTANT: Flash message
        $request->session()->flash('status', 'Berhasil mengganti aktor ke: ' . $allowed[$role]);

        // Redirect ke dashboard per role (INI YANG PENTING - FULL PAGE RELOAD)
        return redirect()->route('dashboard.role', ['role' => $role]);
    }
}
