<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('username', 'password');

        $user = User::where('username', $request->username)->first();
        if ($user && $user->status !== 'enable') {
            return back()->withErrors([
                'username' => 'Akun Anda nonaktif. Silakan hubungi administrator.',
            ])->withInput($request->only('username'));
        }

        // Proses login
        if (Auth::attempt(array_merge($credentials, ['status' => 'enable']), $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // redirect ke dashboard
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
