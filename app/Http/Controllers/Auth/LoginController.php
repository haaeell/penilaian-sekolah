<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function redirectTo()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return '/home';
            case 'guru':
            case 'karyawan':
                return '/hasil-penilaian';
            case 'siswa':
                return '/penilaian';
            default:
                return '/home';
        }
    }
}
