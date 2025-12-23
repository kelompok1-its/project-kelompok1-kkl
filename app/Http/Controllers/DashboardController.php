<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\SkMengajar;

class DashboardController extends Controller
{
    /**
     * Dashboard utama
     * Jika sudah ada role di session → redirect ke dashboard sesuai role
     */
    public function index()
    {
        $role = session('current_role_slug');

        if ($role) {
            return redirect()->route('dashboard.role', ['role' => $role]);
        }

        return view('dashboard.index', $this->commonData());
    }

    /**
     * Dashboard berdasarkan role
     */
    public function showByRole(Request $request, $role)
    {
        $roles = [
            'akademik' => 'Akademik',
            'kaprodi'  => 'Kaprodi',
            'dekan'    => 'Dekan',
            'wr1'      => 'Wakil Rektor I',
            'dosen'    => 'Dosen',
        ];

        $role = strtolower($role);

        if (!isset($roles[$role])) {
            abort(404);
        }

        session([
            'current_role' => $roles[$role],
            'current_role_slug' => $role,
        ]);

        $data = $this->commonData();
        $data['current_role_slug']  = $role;
        $data['current_role_label'] = $roles[$role];

        $view = "{$role}.dashboard";
        if (!view()->exists($view)) {
            $view = 'dashboard.index';
        }

        return view($view, $data);
    }

    /**
     * Data umum dashboard (AMAN – tanpa status)
     */
    private function commonData()
    {
        return [
            // total mata kuliah
            'jumlah_mk' => MataKuliah::count(),

            // total kelas
            'kelas_aktif' => Kelas::count(),

            // total SK mengajar
            'jumlah_sk' => SkMengajar::count(),
        ];
    }
}
