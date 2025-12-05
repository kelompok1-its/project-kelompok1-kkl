<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Index: jika ada session role -> redirect ke dashboard.role
     * jika tidak ada -> tampilkan dashboard umum
     */
    public function index()
    {
        $role = session('current_role_slug', null);

        if ($role) {
            // redirect ke route dashboard.role misal /dashboard/akademik
            return redirect()->route('dashboard.role', ['role' => $role]);
        }

        $data = $this->commonData();
        return view('dashboard.index', $data);
    }

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
        if (! array_key_exists($role, $allowed)) abort(404);

        session([
            'current_role' => $allowed[$role],
            'current_role_slug' => $role,
        ]);

        $data = $this->commonData();
        $data['current_role_slug'] = $role;
        $data['current_role_label'] = $allowed[$role];

        $viewName = "{$role}.dashboard";
        if (! view()->exists($viewName)) $viewName = 'dashboard.index';

        return view($viewName, $data);
    }

    private function commonData()
    {
        return [
            'jumlah_mk' => 24,
            'kelas_aktif' => 12,
            'jumlah_sk' => 1,
        ];
    }
}
