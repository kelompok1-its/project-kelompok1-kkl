<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    protected function authenticated(Request $request, $user)
    {
        // set default ke 'akademik' jika belum ada
        if (! session()->has('current_role_slug')) {
            session([
                'current_role' => 'Akademik',
                'current_role_slug' => 'akademik',
            ]);
        }

        // redirect ke /home (yang sudah kita redirect ke /dashboard/akademik)
        return redirect()->route('home');
    }

    // optional: pastikan logout membersihkan session role
    public function logout(Request $request)
    {
        session()->forget(['current_role', 'current_role_slug']);
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
