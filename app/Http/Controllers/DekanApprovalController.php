<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Ploting;

class DekanApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            $roleSlug = session('current_role_slug', null);

            $isDekan = false;
            if ($user && (isset($user->role) && $user->role === 'dekan')) {
                $isDekan = true;
            }
            if ($roleSlug === 'dekan') {
                $isDekan = true;
            }

            if (! $isDekan) {
                abort(403, 'Unauthorized.');
            }

            return $next($request);
        });
    }

    /**
     * Dashboard kecil untuk semua jenis approval yang dikelola Dekan.
     */
    public function index()
    {
        $counts = [
            'ploting_pending' => 0,
            'sk_mengajar_pending' => 0,
        ];

        // Count pending plotings jika kolom status ada
        if (Schema::hasTable('plotings') && Schema::hasColumn('plotings', 'status')) {
            $counts['ploting_pending'] = Ploting::where('status', 'pending')->count();
        }

        // Jika ada table sk_mengajars dan kolom status, hitung pending
        if (Schema::hasTable('sk_mengajars') && Schema::hasColumn('sk_mengajars', 'status')) {
            $counts['sk_mengajar_pending'] = DB::table('sk_mengajars')->where('status', 'pending')->count();
        }

        return view('dekan.approval.index', compact('counts'));
    }
}
