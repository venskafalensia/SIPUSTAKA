<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $totalBuku = Book::count();
        $totalAnggota = User::where('role', 'siswa')->count();
        $peminjamanAktif = Loan::whereNull('tanggal_kembali')->count();

        return view('admin.profil.index', compact('user', 'totalBuku', 'totalAnggota', 'peminjamanAktif'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
        ]);

        $user->forceFill($data)->save();

        return redirect()->route('admin.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.current_password' => 'Kata sandi saat ini tidak sesuai.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
        ]);

        $user->forceFill(['password' => Hash::make($request->password)])->save();

        return redirect()->route('admin.profil.index')->with('success', 'Kata sandi berhasil diganti.');
    }
}