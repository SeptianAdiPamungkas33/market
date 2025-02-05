<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function prosesLogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Data login
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role_id == 1) {
                return redirect()->route('dashboard-admin'); // Admin
            } elseif (Auth::user()->role_id == 2) {
                return redirect()->route('dashboard-user'); // User
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak valid');
            }
            //$user = Auth::user()->role_id;

            // if ($user->role_id == 1) {
            //     return redirect()->route('dashboard-admin'); // Admin
            // } elseif ($user->role_id == 2) {
            //     return redirect()->route('dashboard-user'); // User
            // } else {
            //     Auth::logout();
            //     return redirect()->route('login')->with('error', 'Role tidak valid');
            // }
        }
        return redirect()->route('login')->with('error', 'Username atau password salah');
    }

    // public function prosesLogin(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'username' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     // Ambil user berdasarkan username
    //     $user = User::where('username', $request->username)->first();

    //     // Periksa apakah user ditemukan dan password cocok
    //     if ($user && Hash::check($request->password, $user->password)) {
    //         // Simpan session user
    //         session(['user_id' => $user->id, 'role_id' => $user->role_id]);

    //         // Redirect berdasarkan role
    //         if ($user->role_id == 1) {
    //             return redirect()->route('dashboard-admin'); // Admin
    //         } elseif ($user->role_id == 2) {
    //             return redirect()->route('dashboard-user'); // User
    //         } else {
    //             session()->flush();
    //             return redirect()->route('login')->with('error', 'Role tidak valid');
    //         }
    //     }

    //     return redirect()->route('login')->with('error', 'Username atau password salah');
    // }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout berhasil');
    }
}
