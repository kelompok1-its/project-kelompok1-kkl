<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * General dashboard (default).
     */
    public function index()
    {
        $data = $this->commonData();

        // Jika session punya role, tunjukkan dashboard role tersebut
        $role = session('current_role_slug', null);
        if ($role) {
            return $this->showByRole(request(), $role);
        }

        return view('dashboard.index', $data);
    }

    /**
     * Show dashboard for a specific role.
     * Will attempt to render view "{role}.dashboard" (e.g. "akademik.dashboard").
     * If view missing, fallback to "dashboard.index".
     */
    public function showByRole(Request $request, $role)
    {
        $allowed = [
            'akademik' => 'Akademik',
            'kaprodi'  => 'Kaprodi',
            'dekan'    => 'Dekan',
            'wr1'      => 'Wakil Rektor I',
            'dosen'    => 'Dosen',
        ];

        $role = strtolower($role);

        if (! array_key_exists($role, $allowed)) {
            abort(404);
        }

        // set session supaya UI tahu role aktif
        session([
            'current_role' => $allowed[$role],
            'current_role_slug' => $role,
        ]);

        $data = $this->commonData();
        $data['current_role_slug'] = $role;
        $data['current_role_label'] = $allowed[$role];

        // cek view di path "{role}.dashboard"
        $viewName = "{$role}.dashboard";
        if (! view()->exists($viewName)) {
            $viewName = 'dashboard.index';
        }

        return view($viewName, $data);
    }

    private function commonData()
    {
        // ambil data nyata dari DB jika ada; ini contoh dummy
        return [
            'jumlah_mk' => 24,
            'kelas_aktif' => 12,
            'jumlah_sk' => 1,
        ];
    }
}
