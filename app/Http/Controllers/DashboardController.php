<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\User;
use App\Models\Ploting;

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
            // UMUM (dipakai akademik)
            'jumlah_mk'   => \App\Models\MataKuliah::count(),
            'kelas_aktif' => \App\Models\Kelas::count(),
            'jumlah_sk'   => \App\Models\SkMengajar::count(),

            // KHUSUS PLOTTING (kaprodi)
            'dosen_tersedia' => \App\Models\User::where('role', 'dosen')->count(),
            'ploting_belum_selesai' => \App\Models\Ploting::where(function ($q) {
                $q->where('status', 'pending')
                    ->orWhereNull('final_status');
            })->count(),
        ];
    }
}
