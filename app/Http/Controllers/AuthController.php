<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'account_type' => 'required|in:student,admin',
        ]);

        $role = $request->account_type === 'admin'
            ? 'admin'
            : 'siswa';

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'role' => $role,
        ];

        if (Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            $request->session()->regenerate();

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('siswa.dashboard');
        }

        return back()
            ->withInput($request->only('username'))
            ->with('login_error', 'Username atau kata sandi salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

// Menampilkan halaman pendaftaran siswa
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses data pendaftaran siswa baru
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username', // NISN atau Username
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // Harus ada input konfirmasi password
        ], [
            'username.unique' => 'NISN / Username ini sudah terdaftar.',
            'email.unique' => 'Email ini sudah digunakan.',
            'password.min' => 'Kata sandi minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Buat user baru dengan role 'siswa'
        $user = \App\Models\User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'siswa', // Otomatis diset sebagai siswa
        ]);

        // Otomatis langsung login setelah berhasil daftar
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('siswa.dashboard')->with('success', 'Akun berhasil dibuat!');
    }
}
